<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $category
 * @property mixed $author
 * @property mixed $id
 * @property mixed $source
 * @property mixed $title
 * @property mixed $description
 * @property mixed $url
 * @property mixed $image_url
 * @property mixed $published_at
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'source' => $this->source,
            'author' => $this->author,
            'category' => $this->category,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'published_at' => Carbon::createFromTimestamp($this->published_at)->format('Y-m-d'),
        ];
    }
}
