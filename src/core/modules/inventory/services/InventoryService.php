<?php

namespace Core\Modules\Inventory\Services;

use Core\Modules\Inventory\Entities\Inventory;
use Core\Modules\Inventory\Orm\CategoryRepository;
use Core\Modules\Inventory\Orm\InventoryRepository;
use Core\Modules\Inventory\Requests\InventoryRequest;

class InventoryService
{
    private $inventoryRepository;
    private $categoryRepository;

    /**
     * InventoryService constructor.
     * @param InventoryRepository $inventoryRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(InventoryRepository $inventoryRepository, CategoryRepository $categoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
        $this->categoryRepository = $categoryRepository;
    }


    function createInventory(InventoryRequest $request){
        $category = $this->categoryRepository->findById(
            $request->getCategoryId()
        );
        $inventory = new Inventory();
        $inventory->setId($request->getId());
        $inventory->setName($request->getName());
        $inventory->setCategory($category);
        $inventory->setDescription($request->getDescription());
        $inventory->setType($request->getType());
        $inventory->setPrice($request->getPrice());
        $inventory->setQuantity($request->getQuantity());

        return $this->inventoryRepository->createInventory($inventory);
    }

    function updateInventory(InventoryRequest $request){
        $inventory = $this->inventoryRepository->findById($request->getId());

        $category = $this->categoryRepository->findById(
            $request->getCategoryId()
        );

        $inventory->setCategory($category);
        return $this->inventoryRepository->updateInventory($inventory);
    }

    function getInventory(int $inventoryId){
        return $this->inventoryRepository->findById($inventoryId);
    }

    function deleteInventory(int $inventoryId){
        $this->inventoryRepository->deleteById($inventoryId);
    }
}