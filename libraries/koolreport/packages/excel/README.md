# Introduction

`Excel` package helps you to work with Excel. It can help to pull data from Excel file as well as push data to Excel file. Underline of `ExcelDataSource` is the open-source library called `phpoffice/PHPExcel` which helps us to read various Excel version.

# Installation

1. Unzip folder
2. Copy the `excel` folder to `koolreport\packages`

# Documentation

## Get data from Excel (version >= 1.0.0)

`ExcelDataSource` help you to get data from your current Microsoft Excel file.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\ExcelDataSource'|
|filePath|string||The full file path to your Excel file.|
|charset|string|`"utf8"`|Charset of your Excel file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|sheetName|string|null|Set a sheet name to load instead of all sheets. (version >= 2.1.0)|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first.  (version >= 2.1.0)|

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\ExcelDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "charset"=>"utf8",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1", // (version >= 2.1.0)
                    "sheetIndex"=>0, // (version >= 2.1.0)
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Export to Excel (version >= 1.0.0)

To use the export feature in report, you need to register the `ExcelExportable` in your report like below code

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\ExcelExportable;
    ...
}
```

Then now you can export your report to excel like this:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel()->toBrowser("myreport.xlsx");
```

If there is a pivot data store in your report, in order to export to excel that data store you need to have the package Pivot.

### General exporting options

When exporting to excel, you could set a number of property for the excel file.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "properties" => array(
        "creator" => "",
        "title" => "",
        "description" => "",1
        "subject" => "",
        "keywords" => "",
        "category" => "",
    )
))->toBrowser("myreport.xlsx");
```

### Normal Excel exporting options (version >= 3.0.0)

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            "columns"=>array(
                0, 1, 2, 'column3', 'column4' //if not specifying, all columns are exported
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

### Pivot excel exporting options 

Beside general options, when exporting a pivot data store you could set several options similar to when viewing a pivot table widget.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            'rowDimension' => 'column',
            'columnDimension' => 'row',
            "measures"=>array(
                "dollar_sales - sum", 
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

## Export to CSV (version >= 3.0.0)

CSVExportable trait allows you to export datastores to CSV files.

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\CSVExportable;
    ...
}
```

### CSV exporting options

'delimiter' option defines a string used to separate columns in the exported CSV file. Default value is a comma.
'columns' option is an array defining a list of columns in the exported CSV file. Values could be either column indexes, column keys or column labels. if not specified, all columns are exported

```
<?php
$report = new MyReport;
$report->run()->exportToCSV(array(
    "dataStores" => array(
        'salesReport' => array(
            'delimiter' => ';',
            "columns"=>array(
                0, 1, 2, 'column3', 'column4'
            )
        )
    )
))->toBrowser("myreport.csv");
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
