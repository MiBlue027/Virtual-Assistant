<?php

namespace Path;

class PathEndpoint
{
    #region AI ENDPOINT
    public const CHAT_BOT_WITH_TTS = "chat-bot-tts";
    public const CHAT_BOT_WITHOUT_TTS = "chat-bot";
    public const CHAT_BOT_WITH_STREAM_TTS = "chat-bot-stream-tts";
    public const CHAT_BOT_GET_STREAM_TTS = "chat-bot-stream-tts-get";
    #endregion

    #region EXCEPTION ENDPOINT
    public const PAGE_NOT_FOUND = "404";
    public const PAGE_ERROR = "page-error";
    public const PAGE_FORBIDDEN = "page-forbidden";
    public const UNAUTHORIZED = "unauthorized";
    #endregion

    #region GENERAL ENDPOINT
    public const ACTIVATION = "activation";
    public const ADD = "add";
    public const DELETE = "delete";
    public const EDIT = "edit";
    public const LOGIN = "login";
    public const LOGOUT = "logout";
    public const REGISTER = "register";
    public const REVIEW = "review";
    public const VIEW = "view";
    #endregion

    #region USER_MANAGEMENT ENDPOINT
    public const GET_ROLE_BY_ID = "get-role-by-id";
    #endregion

    #region UIC_FRAME ENDPOINT
    public const NEW_USER_LIST = "new-user-list";
    public const NEW_USER_SETTING = "new-user-setting";
    #endregion
}