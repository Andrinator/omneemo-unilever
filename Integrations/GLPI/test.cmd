@echo off
chcp 1251

set str="Outer"
@echo:%str%
CALL :SetValue str
@echo:%str%
EXIT /B %ERRORLEVEL%
:SetValue

set str="Inner"
set "%~1=%str%"

EXIT /B 0