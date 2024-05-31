<?php  include "content/dark-theme/view/dark_header.php"; ?>

<?php  

if (empty($_SESSION['username'])) {


echo "<div style='font-size:1.5em; position: fixed; z-index:9999; top: 50%; left: 50%; transform: translate(-50%, -50%); background:white; padding:50px; border-radius:20px;' >
    Oyun oynamak için giriş yapınız. 
    <br> 
    Eğer hesabınız yok ise <a style='color:limegreen; padding:5px 10px;' href='https://bit.ly/atabetkayit' >Kayıt Ol</a>
    </div>";

}

 ?>

 
    <script type="text/javascript">

        function openHogaming(id) {
            
             window.open("/LiveCasino/Game/"+id,'_blank');
            
            window.location.href = "https://atabet.bet/LiveCasino/Slot";
            
           
        }

    </script>

    
    <style>
        
    .TV-gameContainer{
        color:white;
        width:100%;
        height:100%;
        display:flex;
        flex-direction:row;
        justify-content:center;
        background:rgba(0,0,0, 0.4);
    }
    .TV-gameContainer > .TV-toolBox{
        color:white;
        display:flex;
        flex-direction:column;
        align-items:center;

        
        background:#233241;
        color:white;
        height:100px;
        width:40px;
        
        margin-top:10px;
        margin-left:5px;
        border-radius:10px;
    }
    .TV-gameContainer > .TV-toolBox > div > i{
        margin-top:5px;
        padding:0px 25px;
        font-size:2em;
        cursor:pointer;
    }
    
    @media only screen and (max-width: 1000px) {
    .TV-gameContainer{
        flex-direction: row-reverse;
    }
    .TV-gameContainer > .TV-toolBox{
        position:absolute;
        z-index:999;
        right:10px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        
        background:#233241;
        color:white;
        height:40px;
        width:40px;
        
        margin-top:0px;
        margin-left:0px;
    }
    }
        
    </style>
    

    
    <?php  
    $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $gameId = explode("?", $url);

    $gameUrl = "https://atabet.bet/GameLoby/Game/".$gameId[1];
    
    if($gameId[1] == 95){
    
     ?>
    


    <style>
    
    #loby-iframe{
                width:100%; 
                height:calc(100% - 120px);
            }
    
    @media only screen and (max-width: 1000px) {
            #loby-iframe{
                width:100%; 
                height:100%;
            }
    }
    
    </style>
    

    

    
    <div class="TV-gameContainer" style="position:fixed; z-index:999; background:black;" >
        
        
    <iframe id="loby-iframe"
            src="<?php echo $gameUrl; ?>"
            frameborder="0"
            scrolling="no"
            allowfullscreen
            allow="autoplay">
    </iframe>
    
    </div>
    
     <?php 
    
    }else{
    
     ?>
    
    

    <style>
    
    #loby-iframe{
                width:1200px; 
                height:700px;
            }
    
    @media only screen and (max-width: 1000px) {
            #loby-iframe{
                width:100%; 
                height:600px;
            }
    }
    
    </style>
    
    
    
    <div class="TV-gameContainer" >
    
    <iframe id="loby-iframe"
            src="<?php echo $gameUrl; ?>"
            frameborder="0"
            scrolling="no"
            allowfullscreen
            allow="autoplay">
    </iframe>
    
    <div class="TV-toolBox">
        
    <div onclick="openHogaming(<?php  echo $gameId[1];  ?>)">
        <i class="fa-solid fa-expand"></i>
    </div>
        
    </div>
    
    </div>
    
     <?php 
    
    }
    
     ?>
    

    

<?php  include "content/dark-theme/view/dark_footer.php"; ?>
