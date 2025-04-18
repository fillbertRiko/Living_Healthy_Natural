<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Resources\Pages\ViewRecord;

/**
 * Class ViewComment
 *
 * Trang hiển thị chi tiết của một bình luận (Comment) trong hệ thống quản lý Filament.
 *
 * @package App\Filament\Resources\CommentResource\Pages
 */
class ViewComment extends ViewRecord
{
    protected static string $resource = CommentResource::class;

    // Nếu cần tùy chỉnh thêm tiêu đề trang, bạn có thể ghi đè phương thức getTitle() ở đây.
}
