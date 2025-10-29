<?php

namespace Path\View;

class ViewTitle
{


    #region EXCEPTION
    public const PAGE_ERROR_TITLE = "page error";
    public const PAGE_NOT_FOUND_TITLE = '404';
    public const UNAUTHORIZED_TITLE = 'Unauthorized';
    #endregion

    #region OFFICE MANAGEMENT
    public const OFFICE_ADD_TITLE = 'Office Add';
    public const OFFICE_EDIT_TITLE = 'Office Edit';
    public const OFFICE_LIST_VIEW_TITLE = "office view";
    #endregion

    #region ROLE MANAGEMENT
    public const ROLE_ADD_TITLE = "role add";
    public const ROLE_EDIT_TITLE = "role edit";
    public const ROLE_VIEW_TITLE = "role view";
    #endregion

    #region USER AUTHENTICATION
    public const LOGIN_ADMIN_TITLE = "login";
    #endregion

    #region USER MANAGEMENT
    public const USER_EDIT_TITLE = "user edit";
    public const USER_REGISTRATION_TITLE = "user registration";
    public const USER_VIEW_LIST_TITLE = "user view";
    #endregion
}