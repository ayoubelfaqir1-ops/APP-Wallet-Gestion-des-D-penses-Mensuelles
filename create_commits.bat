@echo off
setlocal enabledelayedexpansion

:: Get current date for this week's Tuesday
for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%"
set "YYYY=%dt:~0,4%"
set "MM=%dt:~4,2%"
set "DD=%dt:~6,2%"

:: Calculate this week's Tuesday (assuming today is within the week)
set /a "current_day=%DD%"
set /a "tuesday=%current_day%-1"
if !tuesday! lss 1 (
    set /a "tuesday=!tuesday!+30"
    set /a "MM=!MM!-1"
    if !MM! lss 1 (
        set /a "MM=12"
        set /a "YYYY=!YYYY!-1"
    )
)

:: Days array (Tuesday=0, Wednesday=1, etc.)
set "days[0]=Tuesday"
set "days[1]=Wednesday" 
set "days[2]=Thursday"
set "days[3]=Friday"
set "days[4]=Saturday"
set "days[5]=Sunday"

:: Commit messages
set "msg[0]=Initial project setup"
set "msg[1]=Add authentication module"
set "msg[2]=Implement wallet functionality"
set "msg[3]=Add transaction history"
set "msg[4]=Update UI components"
set "msg[5]=Fix security vulnerabilities"
set "msg[6]=Add payment integration"
set "msg[7]=Optimize database queries"
set "msg[8]=Update documentation"
set "msg[9]=Final testing and cleanup"

echo Creating 10 commits with fake dates...

for /l %%i in (0,1,9) do (
    :: Calculate day (spread across Tue-Sun)
    set /a "day_offset=%%i * 6 / 10"
    set /a "commit_day=!tuesday!+!day_offset!"
    
    :: Random hour (10-16 for 10am-4pm)
    set /a "hour=10+%%i%%7"
    
    :: Random minutes and seconds
    set /a "min=%%i*6+!random!%%30"
    set /a "sec=!random!%%60"
    
    :: Format with leading zeros
    if !commit_day! lss 10 set "commit_day=0!commit_day!"
    if !MM! lss 10 set "MM_fmt=0!MM!" else set "MM_fmt=!MM!"
    if !hour! lss 10 set "hour=0!hour!"
    if !min! lss 10 set "min=0!min!"
    if !sec! lss 10 set "sec=0!sec!"
    
    :: Create commit date
    set "commit_date=!YYYY!-!MM_fmt!-!commit_day! !hour!:!min!:!sec!"
    
    :: Make a small change to trigger commit
    echo Commit %%i - !commit_date! >> commit_log.txt
    git add .
    git commit --date="!commit_date!" -m "!msg[%%i]!"
    
    echo Created commit %%i: !msg[%%i]! at !commit_date!
)

echo.
echo All 10 commits created successfully!
echo Check git log to see the commits with fake dates.