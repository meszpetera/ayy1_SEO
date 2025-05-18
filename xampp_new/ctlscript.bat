@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\xampp_new\hypersonic\scripts\ctl.bat (start /MIN /B C:\xampp_new\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\xampp_new\ingres\scripts\ctl.bat (start /MIN /B C:\xampp_new\ingres\scripts\ctl.bat START)
if exist C:\xampp_new\mysql\scripts\ctl.bat (start /MIN /B C:\xampp_new\mysql\scripts\ctl.bat START)
if exist C:\xampp_new\postgresql\scripts\ctl.bat (start /MIN /B C:\xampp_new\postgresql\scripts\ctl.bat START)
if exist C:\xampp_new\apache\scripts\ctl.bat (start /MIN /B C:\xampp_new\apache\scripts\ctl.bat START)
if exist C:\xampp_new\openoffice\scripts\ctl.bat (start /MIN /B C:\xampp_new\openoffice\scripts\ctl.bat START)
if exist C:\xampp_new\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\xampp_new\apache-tomcat\scripts\ctl.bat START)
if exist C:\xampp_new\resin\scripts\ctl.bat (start /MIN /B C:\xampp_new\resin\scripts\ctl.bat START)
if exist C:\xampp_new\jboss\scripts\ctl.bat (start /MIN /B C:\xampp_new\jboss\scripts\ctl.bat START)
if exist C:\xampp_new\jetty\scripts\ctl.bat (start /MIN /B C:\xampp_new\jetty\scripts\ctl.bat START)
if exist C:\xampp_new\subversion\scripts\ctl.bat (start /MIN /B C:\xampp_new\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\xampp_new\lucene\scripts\ctl.bat (start /MIN /B C:\xampp_new\lucene\scripts\ctl.bat START)
if exist C:\xampp_new\third_application\scripts\ctl.bat (start /MIN /B C:\xampp_new\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\xampp_new\third_application\scripts\ctl.bat (start /MIN /B C:\xampp_new\third_application\scripts\ctl.bat STOP)
if exist C:\xampp_new\lucene\scripts\ctl.bat (start /MIN /B C:\xampp_new\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\xampp_new\subversion\scripts\ctl.bat (start /MIN /B C:\xampp_new\subversion\scripts\ctl.bat STOP)
if exist C:\xampp_new\jetty\scripts\ctl.bat (start /MIN /B C:\xampp_new\jetty\scripts\ctl.bat STOP)
if exist C:\xampp_new\hypersonic\scripts\ctl.bat (start /MIN /B C:\xampp_new\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\xampp_new\jboss\scripts\ctl.bat (start /MIN /B C:\xampp_new\jboss\scripts\ctl.bat STOP)
if exist C:\xampp_new\resin\scripts\ctl.bat (start /MIN /B C:\xampp_new\resin\scripts\ctl.bat STOP)
if exist C:\xampp_new\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\xampp_new\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\xampp_new\openoffice\scripts\ctl.bat (start /MIN /B C:\xampp_new\openoffice\scripts\ctl.bat STOP)
if exist C:\xampp_new\apache\scripts\ctl.bat (start /MIN /B C:\xampp_new\apache\scripts\ctl.bat STOP)
if exist C:\xampp_new\ingres\scripts\ctl.bat (start /MIN /B C:\xampp_new\ingres\scripts\ctl.bat STOP)
if exist C:\xampp_new\mysql\scripts\ctl.bat (start /MIN /B C:\xampp_new\mysql\scripts\ctl.bat STOP)
if exist C:\xampp_new\postgresql\scripts\ctl.bat (start /MIN /B C:\xampp_new\postgresql\scripts\ctl.bat STOP)

:end

