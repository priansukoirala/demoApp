<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->bigInteger('employee_number');
            $table->string('employee_email');
            $table->string('employee_contact_number');
            $table->string('employee_designation');
            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
        });
        Schema::create('department_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('employee_id');

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
