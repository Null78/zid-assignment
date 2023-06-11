<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Resources\Item\ItemCollection;
use App\Http\Resources\Item\ItemResource;
use App\Models\Item;
use App\Serializers\ItemSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\CommonMark\ConverterInterface;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     * 
     * @return ItemCollection
     */
    public function index(): ItemCollection
    {
        $items = Item::all();
        return ItemCollection::make($items);
    }

    /**
     * Store a newly created item in storage.
     * 
     * @param StoreItemRequest $request
     * @param ConverterInterface $converter
     * @return ItemResource
     */
    public function store(StoreItemRequest $request, ConverterInterface $converter): ItemResource
    {
        $item = Item::create([
            ...$request->only(['name', 'url', 'price']),
            'description' => $converter->convert($request->get('description'))->getContent(),
        ]);

        return ItemResource::make($item);
    }

    /**
     * Display the specified item.
     * 
     * @param Item $item
     * @return ItemResource
     */
    public function show(Item $item): ItemResource
    {
        return ItemResource::make($item);
    }

    /**
     * Update the specified item in storage.
     * 
     * @param UpdateItemRequest $request
     * @param Item $item
     * @param ConverterInterface $converter
     * @return ItemResource
     */
    public function update(UpdateItemRequest $request, Item $item, ConverterInterface $converter): ItemResource
    {
        $item->update([
            ...$request->only(['name', 'url', 'price']),
            'description' => $converter->convert($request->get('description'))->getContent(),
        ]);

        return ItemResource::make($item);
    }
}
