<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'name_uuid',
        'extension',
        'folder',
        'creator_id',
    ];

    public function getRealPath(){
        return storage_path('app/'.$this->folder.'/'.$this->name_uuid);
    }

    public function getSize(){
        $data = getimagesize($this->getRealPath());
        return $data[0].'x'.$data[1];
    }

    public function isImage(){
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'jfif']);
    }

    public function isPdf(){
        return in_array($this->extension, ['pdf']);
    }

    public function isWord(){
        return in_array($this->extension, ['doc', 'docx', 'odt', 'odf', 'rtf', 'html', 'pptx', 'ppt', 'xlsx', 'xls']);
    }
    
    public function user() {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
