<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid4;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[Uuid4]
class Book
{
    #[Column(type: 'uuid', primary: true, field: 'uuid')]
    private UuidInterface $uuid;

    #[Column(type: 'string')]
    private string $title;

    #[Column(type: 'string')]
    private string $description;

    #[Column(type: 'string')]
    private string $cover;

    /**
     * @var Tag[]
     */
    #[ManyToMany(target: Tag::class, through: BookTag::class)]
    protected array $tags;

    /**
     * @var Genre[]
     */
    #[ManyToMany(target: Genre::class, through: BookGenre::class)]
    protected array $genres;

    /**
     * @var Author[]
     */
    #[ManyToMany(target: Author::class, through: BookAuthor::class)]
    protected array $authors;

    /**
     * @param UuidInterface $id
     * @param string $title
     * @param string $description
     * @param string $cover
     */
    public function __construct(UuidInterface $id, string $title, string $description, string $cover)
    {
        $this->uuid = $id;
        $this->title = $title;
        $this->description = $description;
        $this->cover = $cover;
    }


    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCover(): string
    {
        return $this->cover;
    }

    public function setCover(string $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     * @return void
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @param Genre[] $genres
     * @return void
     */
    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param Author[] $authors
     * @return void
     */
    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }
}
