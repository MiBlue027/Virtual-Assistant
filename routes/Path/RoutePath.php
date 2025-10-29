<?php

namespace Path;

class RoutePath
{
    #region ADMIN
    public const LOGIN_ADMIN = "/" . PathBase::USER . "/" . PathGroup::ADMIN . "/" . PathEndpoint::LOGIN;
    public const LOGOUT_ADMIN = "/" . PathBase::USER . "/" . PathGroup::ADMIN . "/" . PathEndpoint::LOGOUT;
    #endregion

    #region EXCEPTION
    public const EXCEPTION_PAGE_ERROR = "/" . PathBase::EXCEPTION . "/" . PathEndpoint::PAGE_ERROR;
    public const EXCEPTION_PAGE_NOT_FOUND = "/" .  PathBase::EXCEPTION . "/" . PathEndpoint::PAGE_NOT_FOUND;
    public const EXCEPTION_SESSION = "/" . PathBase::EXCEPTION . "/" . PathGroup::SESSION . "/";
    public const EXCEPTION_UNAUTHORIZED = "/" . PathBase::EXCEPTION . "/" . PathEndpoint::UNAUTHORIZED;

    #endregion
    
    #region EXTERNAL API

    #endregion

    #region HOME
    public const HOME = "/" . PathBase::HOME;
    #endregion

    #region N8N CHAT BOT
    public const N8N_CHAT_BOT_WITH_TTS = "/" . PathBase::AI . "/" . PathGroup::N8N . "/" . PathEndpoint::CHAT_BOT_WITH_TTS;
    public const N8N_CHAT_BOT_WITHOUT_TTS = "/" . PathBase::AI . "/" . PathGroup::N8N . "/" . PathEndpoint::CHAT_BOT_WITHOUT_TTS;
    public const N8N_CHAT_BOT_WITH_STREAM_TTS = "/" . PathBase::AI . "/" . PathGroup::N8N . "/" . PathEndpoint::CHAT_BOT_WITH_STREAM_TTS;
    public const N8N_CHAT_BOT_GET_STREAM_TTS = "/" . PathBase::AI . "/" . PathGroup::N8N . "/" . PathEndpoint::CHAT_BOT_WITH_STREAM_TTS;
    #endregion

    #region OFFICE
    public const INTERNAL_OFFICE_ADD = "/" . PathBase::INTERNAL . "/" . PathGroup::OFFICE . "/" . PathEndpoint::ADD;
    public const INTERNAL_OFFICE_EDIT = "/" . PathBase::INTERNAL . "/" . PathGroup::OFFICE . "/" . PathEndpoint::EDIT;
    public const INTERNAL_OFFICE_VIEW = "/" . PathBase::INTERNAL . "/" . PathGroup::OFFICE . "/" . PathEndpoint::VIEW;
    #endregion


    #region PROFILE
    public const PROFILE = "/" . PathBase::PROFILE;
    #endregion

    #region ROLE MANAGEMENT
    public const INTERNAL_ROLE_ADD = "/" . PathBase::INTERNAL . "/" . PathGroup::ROLE . "/" . PathEndpoint::ADD;
    public const INTERNAL_ROLE_EDIT = "/" . PathBase::INTERNAL . "/" . PathGroup::ROLE . "/" . PathEndpoint::EDIT;
    public const INTERNAL_ROLE_VIEW = "/" . PathBase::INTERNAL . "/" . PathGroup::ROLE . "/" . PathEndpoint::VIEW;
    #endregion

    #region USER
    public const LOGIN_USER = "/" . PathBase::USER . "/" . PathEndpoint::LOGIN;
    public const LOGOUT_USER = "/" . PathBase::USER . "/" . PathEndpoint::LOGOUT;
    #endregion

    #region USER MANAGEMENT
    public const INTERNAL_USER_ACTIVATION = "/" . PathBase::INTERNAL . "/" . PathGroup::USER . "/" . PathEndpoint::ACTIVATION;
    public const INTERNAL_USER_EDIT = "/" . PathBase::INTERNAL . "/" . PathGroup::USER . "/" . PathEndpoint::EDIT;
    public const INTERNAL_USER_REGISTER = "/" . PathBase::INTERNAL . "/" . PathGroup::USER . "/" . PathEndpoint::REGISTER;
    public const INTERNAL_USER_VIEW_LIST = "/" . PathBase::INTERNAL . "/" . PathGroup::USER . "/" . PathEndpoint::VIEW;
    public const INTERNAL_UIC_POPUP_GET_ROLES_BY_ROLES_ID = "/" . PathBase::INTERNAL . "/" . PathGroup::USER . "/" . PathEndpoint::GET_ROLE_BY_ID;
    #endregion
}