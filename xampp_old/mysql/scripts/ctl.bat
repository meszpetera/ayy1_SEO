@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop


"D:\SZAKDOGA\Sql\mysql\bin\mysqld" --defaults-file="D:\SZAKDOGA\Sql\mysql\bin\my.ini" --standalone
if errorlevel 1 goto error
goto finish

:stop
cmd.exe /C start "" /MIN call "D:\SZAKDOGA\Sql\killprocess.bat" "mysqld.exe"

if not exist "D:\SZAKDOGA\Sql\mysql\data\%computername%.pid" goto finish
echo Delete %computername%.pid ...
del "D:\SZAKDOGA\Sql\mysql\data\%computername%.pid"
goto finish


:error
echo MySQL could not be started

:finish
exit
