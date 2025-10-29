<?php
namespace Path\View;

class PathView
{
    #region USER AUTHENTICATION VIEW
    public const LOGIN_ADMIN = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::USER_AUTHENTICATION_VIEW . "/" . ViewName::LOGIN_ADMIN;
    #endregion

    #region EXCEPTION VIEW
    public const PAGE_ERROR_1 = ViewPathFolder::EXCEPTION . "/" . ViewPathFolder::PAGE_ERROR . "/" . ViewName::PAGE_ERROR_1;
    public const PAGE_NOT_FOUND_1 = ViewPathFolder::EXCEPTION . "/" . ViewPathFolder::PAGE_NOT_FOUND_EXCEPTION . "/" . ViewName::PAGE_NOT_FOUND_EXCEPTION_1;
    public const UNAUTHORIZED_PAGE_1 = ViewPathFolder::EXCEPTION . "/" . ViewPathFolder::UNAUTHORIZED_EXCEPTION . "/" . ViewName::UNAUTHORIZED_EXCEPTION;
    #endregion

    #region ROLE MANAGEMENT VIEW
    public const ROLE_ADD = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::ROLE_MANAGEMENT_VIEW . "/" . ViewName::ROLE_ADD;
    public const ROLE_VIEW = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::ROLE_MANAGEMENT_VIEW . "/" . ViewName::ROLE_VIEW;
    #endregion

    #region USER MANAGEMENT VIEW
    public const USER_ADD_EDIT = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::USER_MANAGEMENT_VIEW . "/" . ViewName::USER_ADD_EDIT;
    public const USER_ROLE_ADD_POPUP = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::USER_MANAGEMENT_VIEW . "/" . ViewName::USER_ROLE_ADD_POPUP;
    public const USER_LIST_VIEW = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::USER_MANAGEMENT_VIEW . "/" . ViewName::USER_VIEW_LIST;
    #endregion

    #region OFFICE MANAGEMENT VIEW
    public const OFFICE_LIST_VIEW = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::OFFICE_MANAGEMENT_VIEW . "/" . ViewName::OFFICE_LIST_VIEW;
    public const OFFICE_ADD_EDIT_VIEW = ViewPathFolder::APP_VIEW . "/" . ViewPathFolder::OFFICE_MANAGEMENT_VIEW . "/" . ViewName::OFFICE_ADD_EDIT_VIEW;
    #endregion
}