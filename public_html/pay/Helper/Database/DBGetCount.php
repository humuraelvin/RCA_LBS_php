<?php

  Namespace Helper\Database;

  Use Library\Database as DB;

  Class DBGetCount {


    /*
     * Dashboard
    */
    Public Static Function photo($tablename,$parent)
    {
      return DB::rowCount("SELECT id FROM sta_sections_website_photo WHERE tablename=? AND parent=?", array($tablename,$parent));
    }

    Public Static Function slider($area)
    {
      return DB::rowCount("SELECT id FROM sta_data_slider_list WHERE area=?", array($area));
    }

    Public Static Function unreadMessage()
    {
      return DB::rowCount("SELECT id FROM sta_form_contact WHERE created_at > ?", array(date("Y-m-d",strtotime("-1 month"))));
    }

    Public Static Function banks()
    {
      return DB::rowCount("SELECT id FROM sta_system_banks");
    }

    Public Static Function users()
    {
      return DB::rowCount("SELECT user_id FROM sta_data_user");
    }
    Public Static Function approvePayments()
    {
      return DB::rowCount("SELECT * FROM sta_data_user_payments where payment_status=?", [0]);
    }
    Public Static Function allPayments()
    {
      return DB::rowCount("SELECT * FROM sta_data_user_payments");
    }


    /*
     * Dashboard/Home
    */
    Public Static Function visitor()
    {
      $date  = date('Y-m-d', strtotime("-1 year", time()));
      return DB::sumColumb("sta_system_statistic", "statisticTotalVisitor", "WHERE statisticTime > '".$date."'");
    }

    Public Static Function pageView()
    {
      $date  = date('Y-m-d', strtotime("-1 year", time()));
      return DB::sumColumb("sta_system_statistic", "statisticPageViews", "WHERE statisticTime > '".$date."'");
    }

    Public Static Function totalContactForm()
    {
      $date  = date('Y-m-d', strtotime("-1 year", time()));
      return DB::sumColumb("sta_system_statistic", "statisticTotalContact", "WHERE statisticTime > '".$date."'");
    }

    Public Static Function totalContactFormm()
    {
      return DB::rowCount("SELECT * FROM sta_form_contact");
    }

    Public Static Function visitorThisMount()
    {
      $date  = date('Y-m');
      return DB::sumColumb("sta_system_statistic", "statisticTotalVisitor", "WHERE statisticTime LIKE '%".$date."%'");
    }

    Public Static Function visitorLastMount()
    {
      $date  = date('Y-m', strtotime("-1 month", time()));
      return DB::sumColumb("sta_system_statistic", "statisticTotalVisitor", "WHERE statisticTime LIKE '%".$date."%'");
    }


    /*
     * Dashboard/Crud Control
    */
    Public Static Function create($slug)
    {
      return DB::rowCount("SELECT slug FROM sta_sections_website WHERE slug=?", array($slug));
    }

  }
