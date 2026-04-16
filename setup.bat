@echo off
setlocal enabledelayedexpansion

set "ROOT=%~dp0"

echo [1/4] Backend Laravel
pushd "%ROOT%backend"
if not exist ".env" (
  copy ".env.example" ".env" >nul
)
call composer install
findstr /R "^APP_KEY=$" ".env" >nul && call php artisan key:generate
popd

echo [2/4] Node service
pushd "%ROOT%node-service"
if not exist ".env" (
  copy ".env.example" ".env" >nul
)
call npm install
popd

echo [3/4] Frontend
pushd "%ROOT%frontend"
if not exist ".env" (
  copy ".env.example" ".env" >nul
)
call npm install
call npm run build
popd

echo [4/4] Done
echo You can now start the apps with:
echo   backend:    cd backend ^&^& php artisan serve --host=127.0.0.1 --port=8000
echo   node:       cd node-service ^&^& npm start
echo   frontend:   cd frontend ^&^& npm run dev
endlocal