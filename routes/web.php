<?php

use App\Http\Controller\AIController\N8nController;
use App\Http\Controller\AppController\UserAuthenticationController;
use App\Http\Controller\AppController\HomeController;
use App\Http\Controller\VirtualAssistantController;
use App\Http\Middleware\Authorization\MustAuthorizedMid;
use App\Http\Middleware\Authorization\MustUnauthorizedMid;
use Path\RouteMethod;
use Path\RoutePath;
use support\Route;

Route::Add(RouteMethod::GET, "/", HomeController::class, "LandingPage");

Route::Add(RouteMethod::GET, "/virtual-assistant", VirtualAssistantController::class, "VirtualAssistantView", [MustAuthorizedMid::class]);
Route::Add(RouteMethod::POST, RoutePath::N8N_CHAT_BOT_WITH_TTS, N8nController::class, N8nController::FUNC_GET_RESPONSE_WITH_TTS, [MustAuthorizedMid::class]);
Route::Add(RouteMethod::POST, RoutePath::N8N_CHAT_BOT_WITHOUT_TTS, N8nController::class, N8nController::FUNC_GET_RESPONSE_WITHOUT_TTS, [MustAuthorizedMid::class]);
Route::Add(RouteMethod::POST, RoutePath::N8N_CHAT_BOT_WITH_STREAM_TTS, N8nController::class, N8nController::FUNC_GET_RESPONSE_WITH_STREAM_TTS, [MustAuthorizedMid::class]);
Route::Add(RouteMethod::GET, RoutePath::N8N_CHAT_BOT_GET_STREAM_TTS, N8nController::class, "GetStreamResponse", [MustAuthorizedMid::class]);

Route::Add(RouteMethod::GET, "/va/upload", VirtualAssistantController::class, "upload_doc_view", [MustAuthorizedMid::class]);
Route::Add(RouteMethod::POST, "/va/upload", VirtualAssistantController::class, "upload_doc", [MustAuthorizedMid::class]);

#region USER_AUTHENTICATION_CTRL
//login
Route::Add(RouteMethod::GET, "/user/login", UserAuthenticationController::class, "login_view", [MustUnauthorizedMid::class]);
Route::Add(RouteMethod::POST, "/user/login", UserAuthenticationController::class, "login_request");
Route::Add(RouteMethod::GET, "/user/logout", UserAuthenticationController::class, "logout");
#endregion

Route::Add(RouteMethod::GET, "/profile", HomeController::class, "profile_redirect", [MustAuthorizedMid::class]);


Route::Run();