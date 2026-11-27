<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CategoryRepository;
use App\State\UserPasswordHasher;
use App\State\CategoryAlphabeticalProvider;
use App\State\CategoryBooksProvider;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;




#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/categories',
            normalizationContext: ['groups' => ['category:list']],
        ),
         new Get(
            uriTemplate: '/category/{id}',
            requirements: ['id' => '\d+'],
        ),
        new Post(
            uriTemplate: '/category',
            status: 301
        ),
        new GetCollection(
            provider: CategoryAlphabeticalProvider::class,
            uriTemplate: '/categories/alphabetical/{order}',
            uriVariables: ['order' => 'string'],
            normalizationContext: ['groups' => ['category:list']],
            outputFormats: ['json' => ['application/json']]
        ),
        new GetCollection(
            uriTemplate: '/categories/{id}/books',
            uriVariables: ['id' => 'int'],
            provider: CategoryBooksProvider::class,
            normalizationContext: ['groups' => ['category:list']],
            outputFormats: ['json' => ['application/json']]
        )
    ],
    normalizationContext: ['groups' => ['category:read', 'category:list']],
    denormalizationContext: ['groups' => ['category:create', 'category:update']],
)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:list'])]
    private ?int $id = null;


    #[ORM\Column(length: 50)]
    #[Groups(['category:list'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
