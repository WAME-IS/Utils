# Utils

Provide examples to each helper

[TOC]

## Array
Array tools library

### sortByPriority
Sort by priority

### getPairs
Get pairs

### encodeMultiArray
Convert multi-array to nice-looking string

### decodeMultiArray
Decode multi-array from string


## Cache


## Date

### toString
Format DateTime to string

### toDateTime
Format string date to DateTime for Doctrine entity

### timeAgoInWords
Czech helper time ago in words


## Doctrine

### removeWherePart
Remove where part from QueryBuilder


## Exception

### handleException
Method used to handle Exceptions. Parameter $showIn can be used to display message in given object. Supported "show in" types are:
- \Nette\Application\UI\Form
- \Nette\Application\UI\Presenter


## File

### rename
Rename file

### getFileInfo
Get file info

### getFileName
Get file name

### getFileExtension
Get file extension

### getFileHash
Get file hash

### getFileMimeType
Get mime-type

### getFileSize
Get file size

### emptyDir
Empty directory

### createDir
Create dir recursive

### findFiles
Find files in folder

### findFolders
Find folders

### moveDir
Move directory with files

### dirnameWithLevels
Get dirname parents


## Form

### getCheckboxData
Get checkbox data


## HttpRequest

### getRequest
Get request

### getParameter
Get parameter

### getParameters
Get parameters


## Latte

### find
Find the most appropriate template


## Paginator
@deprecated


## Slug
@deprecated


## String

### truncate
Truncate string

### dashesToCamelCase
Convert string to CamelCase

### getClassName
Get class name from namespace

### getClassPath
Get class path

### parseTemplate
Parse template

### plural
Get plural of string


## Tree


## Validator

### validateModuleNamespace

### validateModuleName
Validate module name

### validatePresenterName
Validate presenter name

### validateFormat

### validateEntityName
Validate entity name

### getReservedWords
Get reserved words