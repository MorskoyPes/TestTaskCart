<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\View;

use Raketa\BackendTestTask\Domain\Service\CartService;
use Raketa\BackendTestTask\Domain\Cart;

readonly class CartView
{
    public function __construct(
        private CartService $cartService // Использование CartService для получения данных
    ) {
    }

    public function toArray(Cart $cart): array
    {
        return $this->cartService->getCartData($cart); // Использование CartService для получения данных
    }
}
