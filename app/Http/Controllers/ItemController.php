<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Resources\Item\ItemCollection;
use App\Http\Resources\Item\ItemResource;
use App\Models\Item;
use App\Serializers\ItemSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\CommonMark\ConverterInterface;

class ItemController extends Controller
{
    public function index(): ItemCollection
    {
        $items = Item::all();
        return ItemCollection::make($items);
    }

    public function store(StoreItemRequest $request, ConverterInterface $converter)
    {
        $item = Item::create([
            ...$request->only(['name', 'url', 'price']),
            'description' => $converter->convert($request->get('description'))->getContent(),
        ]);

        return ItemResource::make($item);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        $serializer = new ItemSerializer($item);

        return new JsonResponse(['item' => $serializer->getData()]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'url' => 'required|url',
            'description' => 'required|string',
        ]);

        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

        $item = Item::findOrFail($id);
        $item->name = $request->get('name');
        $item->url = $request->get('url');
        $item->price = $request->get('price');
        $item->description = $converter->convert($request->get('description'))->getContent();
        $item->save();

        return new JsonResponse(
            [
                'item' => (new ItemSerializer($item))->getData()
            ]
        );
    }
}
