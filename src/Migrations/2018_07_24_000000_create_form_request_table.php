<?php

use Daikazu\FormRequestHandler\Enums\FormRequestStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormRequestTable extends Migration
{
    private $_prefix = '';

    public function __construct()
    {
        $this->_prefix = config('form-request-handler.table_prefix', '');
    }

    public function up()
    {
        Schema::create($this->_prefix . 'form_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 36)->unique();
            $table->longText('data');
            $table->string('status')->default(FormRequestStatus::PENDING);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->_prefix . 'form_requests');
    }
}
