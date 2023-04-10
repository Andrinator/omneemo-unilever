@echo off
chcp 1251
SETLOCAL EnableDelayedExpansion

for /F %%G in ('curl -X GET ^
  -H "Content-Type: application/json" ^
  -H "Authorization: Basic Z2xwaTpWJVlBOCFQVnIyYionRE5JSU9td3dIVGw=" ^
  -H "App-Token: Y3JymtxosYZr2bpXoWVHxuhRw4eEeMWD50KVEZ9I" ^
  "http://localhost/apirest.php/initSession"') do set _initSessionResponse=%%G

set _initSessionResponse=%_initSessionResponse:"=%
set "_initSessionResponse=%_initSessionResponse:~1,-1%"
set "_initSessionResponse=%_initSessionResponse::==%"
set "%_initSessionResponse:, =" & set "%"

for /F "delims=" %%G in ('curl -X Get ^
  -H "Content-Type: application/json" ^
  -H "Session-Token: %session_token%" ^
  -H "Authorization: Basic Z2xwaTpWJVlBOCFQVnIyYionRE5JSU9td3dIVGw=" ^
  -H "App-Token: Y3JymtxosYZr2bpXoWVHxuhRw4eEeMWD50KVEZ9I" ^
  "http://localhost/apirest.php/Log?sort=date_mod&order=DESC&searchText\[itemtype\]=Computer&searchText\[itemtype_link\]=SoftwareVersion&range=0-20&get_hateoas=false"') do (
    set _logResponse=%%G
  )

set _logResponse=%_logResponse:~2,-2%
set _logResponse=!_logResponse:},{=^

!

set index=0

for /F "usebackq tokens=1-20 delims=" %%I in ('!_logResponse!') do (
  set "logArr[!index!]=%%I"
  call :ComposeLogArray index
)

for /L %%A in (0,1,19) do (
  if defined logArr[%%A] (
    @echo:!logArr[%%A]!
  )
)

for /f %%x in ('wmic path win32_utctime get /format:list') do @echo:%%x

EXIT /B 0

:ComposeLogArray
  set /A index+=1
  set %~1=%index%
  EXIT /B 0

rem for /F "tokens=1* delims=}" %%A in ("%_logResponse%") do (
rem  @echo %%A %%B
rem )

rem for /F "delims=" %%A in ('curl -X GET ^
rem  -H "Content-Type: application/json" ^
rem  -H "Session-Token: %session_token%" ^
rem  -H "Authorization: Basic Z2xwaTpWJVlBOCFQVnIyYionRE5JSU9td3dIVGw=" ^
rem  -H "App-Token: Y3JymtxosYZr2bpXoWVHxuhRw4eEeMWD50KVEZ9I" ^
rem  "http://localhost/apirest.php/computer?sort=last_inventory_update&order=DESC&get_hateoas=false"') do echo %%A

rem echo:%_computerResponse%