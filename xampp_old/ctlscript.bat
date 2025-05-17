@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\xampp_old\hypersonic\scripts\ctl.bat (start /MIN /B C:\xampp_old\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\xampp_old\ingres\scripts\ctl.bat (start /MIN /B C:\xampp_old\ingres\scripts\ctl.bat START)
if exist C:\xampp_old\mysql\scripts\ctl.bat (start /MIN /B C:\xampp_old\mysql\scripts\ctl.bat START)
if exist C:\xampp_old\postgresql\scripts\ctl.bat (start /MIN /B C:\xampp_old\postgresql\scripts\ctl.bat START)
if exist C:\xampp_old\apache\scripts\ctl.bat (start /MIN /B C:\xampp_old\apache\scripts\ctl.bat START)
if exist C:\xampp_old\openoffice\scripts\ctl.bat (start /MIN /B C:\xampp_old\openoffice\scripts\ctl.bat START)
if exist C:\xampp_old\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\xampp_old\apache-tomcat\scripts\ctl.bat START)
if exist C:\xampp_old\resin\scripts\ctl.bat (start /MIN /B C:\xampp_old\resin\scripts\ctl.bat START)
if exist C:\xampp_old\jboss\scripts\ctl.bat (start /MIN /B C:\xampp_old\jboss\scripts\ctl.bat START)
if exist C:\xampp_old\jetty\scripts\ctl.bat (start /MIN /B C:\xampp_old\jetty\scripts\ctl.bat START)
if exist C:\xampp_old\subversion\scripts\ctl.bat (start /MIN /B C:\xampp_old\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\xampp_old\lucene\scripts\ctl.bat (start /MIN /B C:\xampp_old\lucene\scripts\ctl.bat START)
if exist C:\xampp_old\third_application\scripts\ctl.bat (start /MIN /B C:\xampp_old\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\xampp_old\third_application\scripts\ctl.bat (start /MIN /B C:\xampp_old\third_application\scripts\ctl.bat STOP)
if exist C:\xampp_old\lucene\scripts\ctl.bat (start /MIN /B C:\xampp_old\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\xampp_old\subversion\scripts\ctl.bat (start /MIN /B C:\xampp_old\subversion\scripts\ctl.bat STOP)
if exist C:\xampp_old\jetty\scripts\ctl.bat (start /MIN /B C:\xampp_old\jetty\scripts\ctl.bat STOP)
if exist C:\xampp_old\hypersonic\scripts\ctl.bat (start /MIN /B C:\xampp_old\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\xampp_old\jboss\scripts\ctl.bat (start /MIN /B C:\xampp_old\jboss\scripts\ctl.bat STOP)
if exist C:\xampp_old\resin\scripts\ctl.bat (start /MIN /B C:\xampp_old\resin\scripts\ctl.bat STOP)
if exist C:\xampp_old\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\xampp_old\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\xampp_old\openoffice\scripts\ctl.bat (start /MIN /B C:\xampp_old\openoffice\scripts\ctl.bat STOP)
if exist C:\xampp_old\apache\scripts\ctl.bat (start /MIN /B C:\xampp_old\apache\scripts\ctl.bat STOP)
if exist C:\xampp_old\ingres\scripts\ctl.bat (start /MIN /B C:\xampp_old\ingres\scripts\ctl.bat STOP)
if exist C:\xampp_old\mysql\scripts\ctl.bat (start /MIN /B C:\xampp_old\mysql\scripts\ctl.bat STOP)
if exist C:\xampp_old\postgresql\scripts\ctl.bat (start /MIN /B C:\xampp_old\postgresql\scripts\ctl.bat STOP)

:end

