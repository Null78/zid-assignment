<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ItemsStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:stats {--a|average} {--H|highest} {--m|current-month} {--t|total}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display Statistics for the wishlist items';

    protected $statistics = [
        'average',
        'highest',
        'current-month',
        'total',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $options = collect($this->options())
            ->filter(fn ($value, $option) => in_array($option, $this->statistics))
            ->filter(fn ($value, $option) => $value)
            ->keys();

        $data = $options->isEmpty() ?
            $this->getAll()
            : $options->map(fn ($option) => $this->getSelected($option))
            ->toArray();

        $this->table(['Key', 'Value'], $data);
    }

    /**
     * Get the selected statistics
     *
     * @param String $options
     * @return Collection
     */
    public function getSelected(String $options): Collection
    {
        return $this->{'get' . Str::studly($options)}();
    }

    /**
     * Get all statistics
     *
     * @return array
     */
    private function getAll(): array
    {
        return [
            $this->getTotal(),
            $this->getAverage(),
            $this->getHighest(),
            $this->getCurrentMonth(),
        ];
    }

    /**
     * Get the total number of items
     *
     * @return array
     */
    private function getTotal(): array
    {
        return [
            'Key' => 'Total',
            'Value' => Item::count()
        ];
    }

    /**
     * Get the average price of items
     *
     * @return array
     */
    private function getAverage(): array
    {
        return [
            'Key' => 'Average Price',
            'Value' => Item::average('price')
        ];
    }

    /**
     * Get the highest website prices
     *
     * @return array
     */
    private function getHighest(): array
    {
        return [
            'Key' => 'Highest Website Prices',
            'Value' => Item::all()
                ->groupBy(fn ($item) => parse_url($item->url, PHP_URL_HOST))
                ->map(fn ($items) => $items->sum('price'))
                ->sortDesc()
                ->keys()
                ->first()
        ];
    }

    /**
     * Get the current month prices
     *
     * @return array
     */
    private function getCurrentMonth(): array
    {
        return [
            'Key' => 'Current Month Prices',
            'Value' => Item::currentMonth()->sum('price')
        ];
    }
}
