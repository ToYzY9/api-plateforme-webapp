<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CategoryRepository;



final class CategoryAlphabeticalProvider implements ProviderInterface
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): array {
        return $this->categoryRepository->findAllCategoryOrderAlphabetical($uriVariables["order"]);
    }
}
