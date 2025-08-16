<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'email'];
    protected $guarded = ['id'];
    protected $hidden = ['search_vector', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected $searchable = ['name', 'email'];
    protected $sortable = ['name', 'email', 'created_at'];

    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->id = (string) Str::uuid();
        });
    }

    public static function search(array $params)
    {
        $instance = new static();
        $query = static::query();
        // Full-text search using `q`
        if (!empty($params['q']) && property_exists($instance, 'searchable')) {
            $query->whereRaw("search_vector @@ plainto_tsquery('english', ?)", [$params['q']]);
        } else {
            // Field-specific search for each defined searchable field
            foreach ($instance->searchable ?? [] as $field) {
                if (!empty($params[$field])) {
                    $query->where($field, 'ILIKE', '%' . $params[$field] . '%');
                }
            }
        }
        // Date range filters
        if (!empty($params['createdAt'])) {
            $query->whereDate('created_at', $params['createdAt']);
        }
        if (!empty($params['createdAtMin'])) {
            $query->whereDate('created_at', '>=', $params['createdAtMin']);
        }
        if (!empty($params['createdAtMax'])) {
            $query->whereDate('created_at', '<=', $params['createdAtMax']);
        }
        // Sorting
        $sortBy = in_array($params['sortBy'] ?? '', $instance->sortable ?? []) 
            ? $params['sortBy'] 
            : 'created_at';
    
        $order = strtolower($params['order'] ?? 'desc');
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';
        $query->orderBy($sortBy, $order);
        // Pagination
        $limit = is_numeric($params['limit'] ?? null) ? (int) $params['limit'] : 100;
    
        return $query->paginate($limit);
    }
}
