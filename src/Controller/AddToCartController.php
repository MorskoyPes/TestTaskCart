<?php

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Domain\Service\CartService;
use Raketa\BackendTestTask\View\CartView;

readonly class AddToCartController
{
    public function __construct(
        private CartService $cartService, // Использование CartService вместо вызова напрямую репозитория
        private CartView $cartView,
    ) {
    }

    public function get(RequestInterface $request): ResponseInterface
    {
        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $response = new JsonResponse();
        $this->cartService->addToCart($rawRequest['productUuid'], $rawRequest['quantity']);
        $cart = $this->cartService->getCart();  // Использование CartService

        /**
         * Тут можно использовать 404 ответ, если корзина не найдена, как в GetCartController
         */
        if (! $cart) {
            $response->getBody()->write(
                json_encode(
                    ['message' => 'Cart not found'],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json; charset=utf-8')
                ->withStatus(404);
        } else {
            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 'success',
                        'cart' => $this->cartView->toArray($cart)
                    ],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );
        }
        
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus(200);
    }
}
