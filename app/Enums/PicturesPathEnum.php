<?php

namespace App\Enums;

enum PicturesPathEnum: string
{
    case CATEGORY_PICTURES = '/category';
    case CATEGORY_IMAGE = '/image';
    case CATEGORY_BANNER = '/banner';
    case PRODUCT = '/products';
    case USER_LOGO = '/user-images';
}

