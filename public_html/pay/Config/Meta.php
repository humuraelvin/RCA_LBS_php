<?php

  Namespace Config;

  Use Config\Router as Router;
  Use Helper\Database\DBGetID as DBGetID;
  Use Library\Database as DB;


  Class Meta {

    Public Static Function meta($columb)
    {
      $query = DB::single("SELECT $columb FROM sta_sections_website_meta WHERE slug=?", array(slug()));
      return __($query->$columb);
    }

    Public Static Function title()
    {
      if(Router::languageControl())
      {
        if(Router::homePage())
        {
          $title = '<title>'.__(DBGetID::config("metaTitle")).' - '.DBGetID::config("brandName").'</title>';
        }
        else if(Router::websiteSectionControl())
        {
          $title = '<title>'.self::meta("title").' - '.DBGetID::config("brandName").'</title>';
        }
        else
        {
          $title = '<title>Page Not Found - '.DBGetID::config("brandName").'</title>';
        }
      }
      else
      {
        $title = '<title>Page Not Found - '.DBGetID::config("brandName").'</title>';
      }
      return $title;
    }

    Public Static Function description()
    {
      if(Router::languageControl())
      {
        if(Router::homePage())
        {
          $description = '<meta name="description" content="'.__(DBGetID::config("metaDescription")).'">';
        }
        else if(Router::websiteSectionControl())
        {
          $description = '<meta name="description" content="'.self::meta("description").'">';
        }
      }
      return $description;
    }

    Public Static Function canonical()
    {
      $explodeURL = explode('?', PAGE_URL);
      if(substr_count(PAGE_URL,'?')>0) {
        $canonical = '<link rel="canonical" href="'.HTTP.$explodeURL[0].'" />';
      } else {
        $canonical = '<link rel="canonical" href="'.HTTP.PAGE_URL.'" />';
      }
      return $canonical;
    }

    Public Static Function hrefLangs()
    {
      if(MULTILANG)
      {
        if(DB::rowCount("SELECT * FROM sta_system_langs WHERE status=?", array(1))>1)
        {
          $hreflang.= '<link rel="alternate" hreflang="x-default" href="'.PATH.'/tr/'.slug().'" />
          ';
          if(Router::homePage())
          {
            $query    = DB::fetch("SELECT * FROM sta_system_langs WHERE status=?", array(1));
            foreach ($query as $row) {
              $hreflang.= '<link rel="alternate" hreflang="'.$row->code.'" href="'.PATH.'/'.$row->code.'"/>
              ';
            }
          }
          else
          {
            $query    = DB::fetch("SELECT * FROM sta_system_langs WHERE status=?", array(1));
            foreach ($query as $row) {
              $hreflang.= ' <link rel="alternate" hreflang="'.$row->code.'" href="'.PATH.'/'.$row->code.'/'.slug().'"/>
              ';
            }
          }
        }
      }
      return $hreflang;
    }

    Public Static Function robots()
    {
      if(http_response_code()==404)
      {
        $robots = '<meta name="robots" content="noindex" />';
      }
      else
      {
        $robots = '<meta name="robots" content="index, follow" />';
      }
      return $robots;
    }

  }
