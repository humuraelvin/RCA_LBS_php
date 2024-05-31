<?php

  Namespace Config;

  Use Helper\Database\DBGetSlug as DBGetSlug;
  Use Helper\DashboardPermission as Permission;
  Use Helper\Login as Login;
  Use Library\Database as DB;

  Class Router {

    /*
    |--------------------------------------------------------------------------
    | Homepage Kontrolü
    |--------------------------------------------------------------------------
    */
    Public Static Function homePage()
    {
      if(MULTILANG)
      {
        if(strlen(SLUG)==2)
        {
          $homePage = true;
        }
        else
        {
          $homePage = false;
        }
      }
      else
      {
        if(strlen(SLUG)===0)
        {
          $homePage = true;
        }
        else
        {
          $homePage = false;
        }
      }
      return $homePage;
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Kontrolü
    |--------------------------------------------------------------------------
    */
    Public Static Function dashboardSectionControl()
    {
      $query = DB::single("SELECT type FROM sta_sections_dashboard WHERE slug=?", array(PSLUG1));
      return $query->type;
    }

    /*
    |--------------------------------------------------------------------------
    | Website Kontrolü
    |--------------------------------------------------------------------------
    */
    Public Static Function websiteSectionControl()
    {
      $query = DB::single("SELECT type FROM sta_sections_website WHERE slug=?", array(slug()));
      return $query->type;
    }

    /*
    |--------------------------------------------------------------------------
    | Dil Kontrolü
    |--------------------------------------------------------------------------
    */
    Public Static Function languageControl()
    {
      if(MULTILANG)
      {
        return DB::rowcount("SELECT id FROM sta_system_langs WHERE code=? and status=?", array(PSLUG0,1));
      }
      else
      {
        return true;
      }
    }

    /*
    |--------------------------------------------------------------------------
    | ROTER buradan çalışma başlar ve ROOTER tamamen DATABASE'de bulunan sta_sections_website ve sta_sections_dashboard tabloları ile yönetilir.
    |--------------------------------------------------------------------------
    */
    Public Static Function run()
    {
      /*
      |--------------------------------------------------------------------------
      | Bulunduğu Sayfa DASHBOARD ise ROUTER buradan çalışır.
      |--------------------------------------------------------------------------
      */
      if(PSLUG0=='dashboard')
      {
        if(Login::dashboard())
        {
          if(PSLUG0=='dashboard' and !PSLUG1)
          {
            go(PATH_DASHBOARD.'/home');
            die();
          }
          else if(PSLUG0=='dashboard' and PSLUG1=='home')
          {
            includeFile("Project/Backend/Model/Home.php");
            includeFile("Project/Backend/Controller/Home.php");
            includeFile("Project/Backend/View/Include/Header.php");
            includeFile("Project/Backend/View/Home.php");
            includeFile("Project/Backend/View/Include/Footer.php");
            die();
          }
          else if(PSLUG0=='dashboard' and self::dashboardSectionControl())
          {
            if(Permission::rooter($_SESSION['adminPermission'],"%{".DBGetSlug::dashboard("id")."}%"))
            {
              includeFile("Project/Backend/Model/".self::dashboardSectionControl().".php");
              includeFile("Project/Backend/Controller/".self::dashboardSectionControl().".php");
              includeFile("Project/Backend/View/Include/Header.php");
              includeFile("Project/Backend/View/".self::dashboardSectionControl().".php");
              includeFile("Project/Backend/View/Include/Footer.php");
              die();
            }
            else
            {
              header("HTTP/1.1 401 Unauthorized");
              includeFile("Project/Backend/View/Include/Header.php");
              includeFile("Project/Backend/View/401.php");
              includeFile("Project/Backend/View/Include/Footer.php");
              die();
            }
          }
          else
          {
            header('HTTP/1.0 404 Not Found', true, 404);
            includeFile("Project/Backend/View/Include/Header.php");
            includeFile("Project/Backend/View/404.php");
            includeFile("Project/Backend/View/Include/Footer.php");
            die();
          }
        }
        else
        {
          if(PSLUG0=='dashboard' and !PSLUG1)
          {
            go(PATH_DASHBOARD.'/login');
            die();
          }
          else
          {
            includeFile("Project/Backend/Model/Login.php");
            includeFile("Project/Backend/Controller/Login.php");
            includeFile("Project/Backend/View/Include/Header.php");
            includeFile("Project/Backend/View/Login.php");
            includeFile("Project/Backend/View/Include/Footer.php");
            die();
          }
        }
      }

      /*
      |------------------------------------------------------------------------------------------------------------------
      | Burası WEBSITE kısmını ifade eder. Bulunduğu Sayfa DASHBOARD değilse ise ROUTUER buradan çalışır.
      |------------------------------------------------------------------------------------------------------------------
      */
      else
      {
        if(self::languageControl())
        {
          if(self::websiteSectionControl())
          {
            includeFile("Project/Frontend/Model/".self::websiteSectionControl().".php");
            includeFile("Project/Frontend/Controller/".self::websiteSectionControl().".php");
            includeFile("Project/Frontend/View/Include/Header.php");
            includeFile("Project/Frontend/View/".self::websiteSectionControl().".php");
            includeFile("Project/Frontend/View/Include/Footer.php");
            die();
          }
          else if(self::homePage())
          {
            includeFile("Project/Frontend/Controller/Home.php");
            includeFile("Project/Frontend/Model/Home.php");
            includeFile("Project/Frontend/View/Include/Header.php");
            includeFile("Project/Frontend/View/Home.php");
            includeFile("Project/Frontend/View/Include/Footer.php");
            die();
          }
          else
          {
            header('HTTP/1.0 404 Not Found', true, 404);
            includeFile("Project/Frontend/View/Include/Header.php");
            includeFile("Project/Frontend/View/PageNotFound.php");
            includeFile("Project/Frontend/View/Include/Footer.php");
            die();
          }
        }
        else
        {
          header('HTTP/1.0 404 Not Found', true, 404);
          go(PATH);
          die();
        }
      }
    }

  }
