<?php

namespace App\Traits;

use Yajra\DataTables\Facades\DataTables;

trait DatatableBuilder
{
    /**
     * Datatable main object
     *
     * @var mixed
     */
    protected $datatable;

    /**
     * Datatable ID
     *
     * @var string
     */
    protected $datatableId = "datatable";

    /**
     * Datatable source data
     *
     * @var mixed
     */
    protected $datatableSourceData;

    /**
     * Datatable action button
     * Available action SHOW, EDIT, DELETE
     *
     * @var array
     */
    protected $datatableAction = ["SHOW", "EDIT", "DELETE"];

    /**
     * Datatable main route
     *
     * @var mixed
     */
    protected $datatableRoute;

    /**
     * Datatable costum columns
     *
     * @var array
     */
    protected $datatableColumns = [];

    /**
     * Datatable raw columns to render
     * Raw string on datatable
     *
     * @var array
     */
    protected $datatableRawColumns = [];

    /**
     * Datatable header. Make sure header have value
     * to be displayed in datatable script
     *
     * @var array
     */
    protected $datatableHeader = [];

    /**
     * Datatable main process
     *
     * @return void
     */
    public function datatable($sourceData = null)
    {
        $sourceData = ($sourceData != null) ? $sourceData : $this->datatableSourceData;
        $this->datatable = DataTables::of($sourceData)
            ->addIndexColumn();

        if (!empty($this->datatableColumns)) {
            $this->buildColumns();
        }

        if (!empty($this->datatableAction)) {
            $this->buildActions();
        }

        $this->datatable->rawColumns($this->datatableRawColumns);
        return $this->datatable->make(true);
    }

    /**
     * Build action column for datatable
     *
     * @return void
     */
    protected function buildActions()
    {
        array_push($this->datatableRawColumns, 'action');
        $this->datatable->addColumn('action', function ($data) {
            $actions = "<div class='btn-group'>";
            foreach ($this->datatableAction as $action) {
                if ($action == "SHOW") {
                    $actions .= "<a class='btn btn-primary btn-sm' href='"
                        . route($this->datatableRoute . ".show", $data->id) . "'>
                    <i class='anticon anticon-search'></i></a>";
                }

                if ($action == "EDIT") {
                    $actions .= "<a class='btn btn-warning btn-sm' href='"
                        . route($this->datatableRoute . ".edit", $data->id) . "'>
                    <i class='anticon anticon-edit'></i></a>";
                }

                if ($action == "DELETE") {
                    $actions .= "<button class='btn btn-danger btn-sm deleteButton'
                    data-id='$data->id'
                    data-form='#userDeleteButton$data->id'>
                    <i class='anticon anticon-delete'></i></button>
                    <form id='userDeleteButton$data->id' action='"
                        . route($this->datatableRoute . ".destroy", $data->id) . "' method='POST'>"
                        . csrf_field() . " " . method_field('DELETE') . "</form>";
                }
            }
            $actions .= "</div>";
            return $actions;
        });
    }

    /**
     * Build specified column in datatable column
     *
     * @return void
     */
    protected function buildColumns()
    {
        foreach ($this->datatableColumns as $column => $function) {
            array_push($this->datatableRawColumns, $column);
            $this->datatable->addColumn($column, $function);
        }
    }

    /**
     * Build datatable table view
     *
     * @return void
     */
    public function buildDatatableTable()
    {
        $html = '<div class="table-responsive"><table class="table" id="' . $this->datatableId . '"><thead><th>No</th>';
        foreach ($this->datatableHeader as $head => $value) {
            $html .= "<th>" . $head . "</th>";
        }

        if (!empty($this->datatableAction)) {
            $html .= '<th style="width: 10px; text-align: center"><i class="anticon anticon-setting"></i></th>';
        }

        $html .= "</thead></table></div>";
        return $html;
    }

    /**
     * Build datatable script for view
     *
     * @return void
     */
    public function buildDatatableScript(string $sourceRoute = null)
    {
        $route = ($sourceRoute != null) ? $sourceRoute : route($this->datatableRoute . '.list');
        $script = '<script>$(document).ready(function() {var table = $("#' . $this->datatableId . '").DataTable({paginate:true,info:true,sort:true,processing:true,serverside:true,ajax:{headers:{"X-CSRF-TOKEN":"' . csrf_token() . '"},url:"' . $route . '",method:"POST"},columns:[{data: "DT_RowIndex",orderable: false,searchable: false,class: "text-center",width: "10px"},';
        foreach ($this->datatableHeader as $head => $value) {
                $script .= '{data: "' . $value . '"},';
        }

        if (!empty($this->datatableAction)) {
            $script .= '{data: "action"}';
        }

        $script .= "]});})</script>";
        return $script;
    }
}
