@echo off
chcp 1251

@echo off
setlocal EnableDelayedExpansion

for /F "usebackq tokens=1* delims=: " %%a in ('{^
"array1": [{ "1": "xx"}, { "2": "zz"},{ "3": "zz"}, {"4": "xx"}],^
"array2": [{ "1": "xx"}, { "2": "zz"},{ "3": "zz"}, {"4": "xx"}]^
}') do (
   set "values=%%b"
   if defined values (
      set "values=!values: =!"
      @echo:!values!
      set ^"values=!values:},{=^
%do not remove this line%
!^"
      for /F "tokens=1,2 delims=:{}[]" %%x in ("!values!") do set "%%~a[%%~x]=%%y"
   )
)

for /F "tokens=1* delims=: " %%a in (Output.txt) do (
   set "values=%%b"
   if defined values (
      set "values=!values: =!"
      @echo:!values!
      set ^"values=!values:},{=^
%do not remove this line%
!^"
      for /F "tokens=1,2 delims=:{}[]" %%x in ("!values!") do set "%%~a[%%~x]=%%y"
   )
)