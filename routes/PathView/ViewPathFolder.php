<?php

namespace Path\View;

class ViewPathFolder
{
    #region PARENT_PATH
    public const APP_VIEW = "AppView";
    public const EXCEPTION = "Exception";
    #endregion

    #region APP_CHILD_PATH
    public const OFFICE_MANAGEMENT_VIEW = "OfficeManagementView";
    public const ROLE_MANAGEMENT_VIEW = "RoleManagementView";
    public const USER_AUTHENTICATION_VIEW = "UserAuthenticationView";
    public const USER_MANAGEMENT_VIEW = "UserManagementView";
    #endregion

    #region EXCEPTION_CHILD_PATH
    public const PAGE_ERROR = "PageError";
    public const PAGE_NOT_FOUND_EXCEPTION = "PageNotFoundException";
    public const UNAUTHORIZED_EXCEPTION = "UnauthorizedException";
    #endregion
}