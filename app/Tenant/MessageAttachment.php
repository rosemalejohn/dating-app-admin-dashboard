<?php

namespace App\Tenant;

use App\Tenant\Model;

class MessageAttachment extends Model
{

    protected $table = 'mailbox_attachment';

    protected $fillable = ['messageId', 'fileName', 'fileSize', 'hash'];

    protected $appends = ['link'];

    public function message()
    {
        return $this->belongsTo(Message::class, 'messageId');
    }

    public function getLinkAttribute()
    {
        return config('database.connections.tenant.url') . '/ow_userfiles/plugins/mailbox/attachments/attachment_' . $this->id . '_' . $this->hash . '_' . $this->fileName;
    }

}
