<?php
namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JustSteveKing\StatusCode\Http;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CollectionResponse implements Responsable
{
    public function __construct(
        public readonly ResourceCollection $data,
        public readonly Http $status = Http::OK,
    ) {}

    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status->value,
        );
    }
}
