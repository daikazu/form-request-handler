<?php

namespace Daikazu\FormRequestHandler\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;

class FormRequest extends Model
{
    use Notifiable;
    public $email_subject;
    private $slack_webhook_url;
    protected $table = 'form_requests';
    protected $cast = [
        'data' => 'json',
    ];

    protected $guarded = ['id'];


    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        $this->table = config('form-request-handler.table_prefix') . $this->table;
        $this->slack_webhook_url = config('form-request-handler.slack_webhook');
        $this->email_subject = config('form-request-handler.send_to_email_subject');
    }

    /**
     * @param $notification
     * @return mixed
     */
    public function routeNotificationForSlack($notification)
    {
        return $this->slack_webhook_url;
    }

    /**
     * @param $query
     * @param $uuid
     * @param bool $first
     * @return mixed
     */
    public function scopeUuid($query, $uuid, $first = true)
    {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
                    $uuid) !== 1)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        $search = $query->where('uuid', $uuid);
        return $first ? $search->firstOrFail() : $search;
    }

    /**
     * @param $query
     * @param $id_or_uuid
     * @param bool $first
     * @return mixed
     */
    public function scopeIdOrUuId($query, $id_or_uuid, $first = true)
    {
        if (!is_string($id_or_uuid) && !is_numeric($id_or_uuid)) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        if (preg_match('/^([0-9]+|[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12})$/',
                $id_or_uuid) !== 1) {
            throw (new ModelNotFoundException)->setModel(get_class($this));
        }
        $search = $query->where(function ($query) use ($id_or_uuid) {
            $query->where('id', $id_or_uuid)
                ->orWhere('uuid', $id_or_uuid);
        });
        return $first ? $search->firstOrFail() : $search;
    }
}
