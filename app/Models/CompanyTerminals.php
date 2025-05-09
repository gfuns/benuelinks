<?php
namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyTerminals extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return [
            Auth::user()->station,
        ];
    }
}
