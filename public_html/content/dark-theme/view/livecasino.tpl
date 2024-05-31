{php} include "content/dark-theme/view/dark_header.php";{/php}
<div class="navbar-title visible-sm visible-xs">
    <a href="" class="page-title">
        <i class="icon-casino"></i> Slotlar {php} echo $id {/php}
    </a>
</div>

{literal}
<script type="text/javascript">

    /** Güncellenmiş Kodlar (2win and IMP Api) */

    let table_id = '{/literal}{php}echo $id{/php}{literal}';

    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        if (dropdownContent.style.display !== "block") {
            dropdownContent.style.display = "block";
        } else {
            dropdownContent.style.display = "none";
        }
    }

    function searchProviders() {
        var input, filter, providers, provider, i, txtValue;
        input = document.getElementById("providerSearch");
        filter = input.value.toUpperCase();
        providers = document.getElementsByClassName("maxlength");
		

        for (i = 0; i < providers.length; i++) {
            provider = providers[i];
            txtValue = provider.textContent || provider.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                provider.style.display = "";
            } else {
                provider.style.display = "none";
            }
        }
    }

    /*games*/

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }                                                                       

    function createGameItem(game) {
    let col = document.createElement('div');
    col.classList.add('hoverable');
    col.classList.add('casino-animation');

    let a = document.createElement('a');
    a.title = game.name; 
    a.className = "gameImg";
    a.dataset.game = game.id;
    

    let div = document.createElement('div');
    div.className = "casinoImage";
    let span = document.createElement('span');
    span.classList.add('lg');
    span.classList.add('span-height')
    span.style.cssText = "background-image: url('" + game.image + "');";

    let div2 = document.createElement('div');
    div2.className = 'gameHover';
    
    let br = document.createElement('br'); // <br> etiketi oluşturuluyor
    
    let span2 = document.createElement('span');
    span2.innerHTML = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play-circle" class="svg-inline--fa fa-play-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"></path></svg> HEMEN OYNA';
    
    span2.addEventListener('click', () => {
        openGame(game.id);
    });

    let span3 = document.createElement('span');
    span3.innerHTML = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play-circle" class="svg-inline--fa fa-play-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"></path></svg> SANAL PARA İLE OYNA';

    // DEMO butonuna tıklanınca hibir şey yapma (boş fonksiyon)
    span3.addEventListener('click', () => {
        demoGame(game.id);
    });

    let textcenter = document.createElement('div');
    textcenter.className = "text-center";
    let maxlength = document.createElement('div');
    maxlength.className = "maxlength";
    maxlength.style.fontWeight = 'normal';
    maxlength.style.fontSize = "14px";
    maxlength.innerText = game.name;
    let img = document.createElement('img');
    img.src = "https://atabet.bet/images/providers_icons/" + game.provider.toLowerCase().replace(' ', '_') + ".png";
    img.alt = capitalizeFirstLetter(game.provider) + ' Logo';
    img.height = '25';

    textcenter.append(maxlength);
    textcenter.append(img);

    div2.append(span2);
    div2.appendChild(br); // <br> etiketi ekleniyor
    div2.append(span3); // DEMO butonu eklendi
    div.append(span);

    a.append(div);
    a.append(div2);

    col.append(a);
    col.append(textcenter);

    return col;
}

    let gamesData = undefined;
    let dataShown = 0;
    let providerGames = undefined;

    function loadData(data, sort) {
        let container = document.querySelector('#game-container');
        data.forEach((i) => {
            let item = createGameItem(i);
            let appended = container.appendChild(item);
            if (sort === 0) {
                if (biggerGames.classList.contains('active')) {
                    appended.classList.add('col-12');
                    appended.classList.add('col-md-4');
                    appended.classList.add('col-xl-3');
                } else {
                    appended.classList.add('col-6');
                    appended.classList.add('col-md-3');
                    appended.classList.add('col-xl-2');
                    appended.firstChild.firstChild.firstElementChild.classList.remove('lg');
                    appended.firstChild.firstChild.firstElementChild.classList.add('md');
                }
            }
        });
    }

    function loadGames(sort = 0, loadMoreButton) {
        fetch("https://" + window.location.hostname + "/jsonveri.php?type=slot")
            .then(async function (response) {
				return response.json();
            })
            .then(function (jsonResponse) {
                gamesData = jsonResponse;
                dataShown += 24;
                let next = gamesData.slice(dataShown - 24, dataShown);
                console.log(next);
                loadData(next, sort);

                if (dataShown >= gamesData.length) {
                    loadMoreButton.style.display = 'none';
                }

                if (sort === 1) {
                    smallerGames.classList.add("active");
                    biggerGames.classList.remove("active");
                    let divs = document.querySelectorAll('.casino-animation');
                    divs.forEach(function (div) {
                        div.classList.add('col-6');
                        div.classList.add('col-md-3');
                        div.classList.add('col-xl-2');
                        div.classList.remove('col-12');
                        div.classList.remove('col-md-4');
                        div.classList.remove('col-xl-3');
                    });
                    let divs2 = document.querySelectorAll('.span-height');
                    divs2.forEach(function (div2) {
                        div2.classList.add('md');
                        div2.classList.remove('lg');
                    });
                }
            })
            .catch(function (error) {
            	console.log(error);
            });
    }

    function makeNotFound() {
        let div1 = document.createElement('div');
        div1.id = "not-found-message";
        div1.className = "col-12";
        div1.style.display = "none";
        let div2 = document.createElement('div');
        div2.className = "placeholder";
        div2.innerText = "Bir sonuç bulunamadı.";
        div1.appendChild(div2);
        return div1;
    }

    function loadProvider(provider) {
        toggleDropdown();
        providerGames = undefined;
        let before = document.querySelector('.active-provider');
        if(before !== null)
            before.classList.remove('active-provider');
        provider.classList.add('active-provider')
        providerGames = gamesData.filter((item) => {
		
            return item.provider.toLowerCase() === provider.id.toLowerCase();
        });
        /* reset the container */
        let container = document.querySelector('#game-container');
        container.innerHTML = '';
        container.append(makeNotFound());

        /* renew load more button click event */
        let parent = document.getElementById('load-more-button').parentElement;
        document.getElementById('load-more-button').remove();
        let newButton = document.createElement('button');
        newButton.id = "load-more-button";
        newButton.classList.add("btn");
        newButton.classList.add("loginbutton");
        newButton.type = "button";
        newButton.innerText = "Daha Fazla";
        let new_lmb = parent.appendChild(newButton);
        new_lmb.addEventListener('click', () => {
            dataShown += 12;
            let next = providerGames.slice(dataShown - 12, dataShown);
            loadData(next, 0);

            if (dataShown >= gamesData.length) {
                new_lmb.style.display = 'none';
            }
        });

        /* load */
        dataShown = 0;
        dataShown += 12;
        let next = providerGames.slice(dataShown - 12, dataShown);
        loadData(next, 0);
    }

</script>
{/literal}


<section id="main" class="sportsbook_padding newCasino">

    <div id="large-slider" class="carousel slide mobile-casino" data-ride="carousel"
         style="border-radius: 20px;">
        <ol class="carousel-indicators">
            <!--- {php} var_dump($casino_banners) {/php} --->
            {php}$i = 0;{/php}
            {foreach from="$casino_banners" item="banner" key="key"}
                <li data-target="#large-slider"
                    data-slide-to="{php}echo $i;{/php}" class="{php} if ($i == 0) { echo "active";} {/php}"></li>
                {php}$i++;{/php}
            {/foreach}
        </ol>
        <div class="carousel-inner" role="listbox">
            {php}$i = 0;{/php}
            {foreach from="$casino_banners" item="banner" key="key"}
            <div class="item {php} if ($i == 0) { echo " active
            ";} {/php}" data-bgcolor="">
            <a href="" target="">
                <img alt="" src="{php}echo $banner->path;{/php}" style="border-radius:20px;">
            </a>
            <div class="carousel-caption container banner-caption">
                <div class="col-xs-offset-1 col-sm-offset-0 col-xs-6 col-ms-offset-2">
                    <div class="bordered-text" style="display: none">
                        <h2><span>{php}echo $banner->text;{/php}</span></h2>
                    </div>
                    <div class="caption-slide-message">
                        <div class="caption-slide-message-wrp">
                            <span class="message-span"
                                  style="display: none">{php}echo $banner->description;{/php}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {php}$i++;{/php}
        {/foreach}
    </div>
    <a class="left carousel-control hidden-xs" href="#large-slider" role="button" data-slide="prev">
        <span class="glyphicon-chevron-left icon-arrow-left" aria-hidden="true"></span> <span
                class="sr-only">Geri</span>
    </a>
    <a class="right carousel-control hidden-xs" href="#large-slider" role="button" data-slide="next">
        <span class="glyphicon-chevron-right icon-arrow-right" aria-hidden="true"></span> <span
                class="sr-only">İleri</span>
    </a>
    </div>

    <div class="container" style="margin-top: 10px;">
        <div class="no-gutters categoryBand">
            <div class="providerFilter col">
                <button type="button" class="osc btn btn-primary" onclick="toggleDropdown()">
                    <span class="osc">Sağlayıcılar</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                         class="svg-inline--fa fa-caret-down fa-w-10 osc" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 320 512">
                        <path fill="currentColor"
                              d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path>
                    </svg>
                </button>


            </div>

            <div style="display:flex;align-items: center;align-content: center;flex-wrap: wrap;">
                <div style="max-width: 110px;" class="miniFilter col">
                    <span class="" id="biggerGames"><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                         data-icon="th-large"
                                                         class="svg-inline--fa fa-th-large fa-w-16 " role="img"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path
                                    fill="currentColor"
                                    d="M296 32h192c13.255 0 24 10.745 24 24v160c0 13.255-10.745 24-24 24H296c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24zm-80 0H24C10.745 32 0 42.745 0 56v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zM0 296v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm296 184h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H296c-13.255 0-24 10.745-24 24v160c0 13.255 10.745 24 24 24z"></path></svg>
                    </span>
                    <span class="" id="smallerGames"><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                          data-icon="th"
                                                          class="svg-inline--fa fa-th fa-w-16 " role="img"
                                                          xmlns="http://www.w3.org/2000/svg"
                                                          viewBox="0 0 512 512"><path fill="currentColor"
                                                                                      d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg></span>
                </div>

                {literal}
                    <script type="text/javascript">
                        let biggerGames = document.getElementById('biggerGames');
                        let smallerGames = document.getElementById('smallerGames');

                        biggerGames.addEventListener('click', function () {
                            smallerGames.classList.remove("active");
                            biggerGames.classList.add("active");
                            let divs = document.querySelectorAll('.casino-animation');
                            divs.forEach(function (div) {
                                div.classList.remove('col-6');
                                div.classList.remove('col-md-3');
                                div.classList.remove('col-xl-2');
                                div.classList.add('col-12');
                                div.classList.add('col-md-4');
                                div.classList.add('col-xl-3');
                            });
                            let divs2 = document.querySelectorAll('.span-height');
                            divs2.forEach(function (div2) {
                                div2.classList.remove('md');
                                div2.classList.add('lg');
                            });
                        });

                        smallerGames.addEventListener('click', function () {
                            biggerGames.classList.remove("active");
                            smallerGames.classList.add("active");
                            let divs = document.querySelectorAll('.casino-animation');
                            divs.forEach(function (div) {
                                div.classList.remove('col-12');
                                div.classList.remove('col-md-4');
                                div.classList.remove('col-xl-3');
                                div.classList.add('col-6');
                                div.classList.add('col-md-3');
                                div.classList.add('col-xl-2');
                            });

                            let divs2 = document.querySelectorAll('.span-height');
                            divs2.forEach(function (div2) {
                                div2.classList.add('md');
                                div2.classList.remove('lg');
                            });
                        });
                    </script>
                {/literal}
                <div class="col-8">
                    <div class="input-group filter"><input type="text" class="form-control" placeholder="Arama" id="search_games" aria-label="Arama" onkeyup="searchGames()">
                        <div class="input-group-append">
                            <span class="input-group-text"><svg aria-hidden="true"
                                                                focusable="false"
                                                                data-prefix="fas"
                                                                data-icon="search"
                                                                class="svg-inline--fa fa-search fa-w-16 "
                                                                role="img"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 512 512"><path
                                            fill="currentColor"
                                            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div id="dropdownContent" role="tooltip" x-placement="bottom" id="providerMenu" class="fade providersTooltip tooltip bs-tooltip-bottom">
    <div class="arrow" style="position: absolute; left: 0px; transform: translate3d(0px, 0px, 0px);"></div>
    <div class="tooltip-inner">
        <div class="filter osc">
            <input type="text" class="form-control osc" placeholder="Sağlayıcı arama..." aria-label="Sağlayıcı arama..." id="providerSearch" onkeyup="searchProviders()">
        </div>
        {php}

        $baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
        $apiUrl = 'https://atabet.bet/jsonveri.php';


        $context = stream_context_create($contextOptions);

        $response = file_get_contents($apiUrl, false, $context);
        $data = json_decode($response, true);

        $saglayiciArray = array();

        if ($data !== null) {
            foreach ($data as $game) {
                $providerName = $game['provider'];
                if (!in_array($providerName, $saglayiciArray)) {
                    $saglayiciArray[] = $providerName;
                    $imgFormat = str_replace(" ", "_", $providerName);
                    $imgFormat = strtolower($imgFormat);
                    echo "
                    <div class='maxlength osc' onClick='loadProvider(this)' id='".$providerName."'>
                        <img class='osc' src='https://atabet.bet/images/providers_icons/".$imgFormat.".png' alt='".$providerName." Logo'>".$providerName."
                    </div>
                    ";
                }
            }
        } else {
            echo "JSON verisi işlenemedi.";
        }
        {/php}
    </div>
</div>


        <div class="no-gutters" id="game-container" style="margin-top: 1vh;display: flex;flex-wrap: wrap;">
            <div class="col-12" id="not-found-message" style="display:none;">
                <div class="placeholder">Bir sonuç bulunamadı.</div>
            </div>
        </div>
        <div class="no-gutters load-more-button">
            <div class="col-12 text-center">
                <button type="button" class="btn loginbutton" id="load-more-button">Daha Fazla Göster</button>
            </div>
        </div>
        {literal}
            <script type="text/javascript">
                const lmb = document.getElementById('load-more-button');
                loadGames(1, lmb);

                lmb.addEventListener('click', () => {
                    loadGames(0, lmb)
                })

                let oldResults = undefined;
                let results = [];
				

                function searchGames() {
                    var searchBar = document.getElementById('search_games');
                    let notFoundMessage = document.getElementById('not-found-message');
                    var query = searchBar.value.toLowerCase();
                    let games = document.getElementsByClassName('hoverable casino-animation col-6 col-md-3 col-xl-2');
                    notFoundMessage.style.display = 'none';

                    if (query.length >= 1)
                        lmb.style.display = 'none';
                    else
                        lmb.style.display = 'inline-block';

                    if (query.length <= 2) {
                        for (let i = 0; i < games.length; i++) {
                            games[i].style.display = 'block';
                        }
                        results.forEach((item) => {
                            item.remove();
                        })
                    }


                    if (query.length < 3)
                        return null;


                    let found = false;
					
                    for (let i = 0; i < games.length; i++) {
                        var gameName = games[i].querySelector('.maxlength').textContent.toLowerCase();
                        var gameProvider = games[i].querySelector('img').alt.toLowerCase();
						

                        if ((gameName.indexOf(query) > -1 || gameProvider.indexOf(query) > -1)) {
                            found = true;
                            games[i].style.display = 'block'; 
                        } else {
                            games[i].style.display = 'none'; 
                        }
                    }

                    if (found === false) {
                        let result = gamesData.filter(item => {
                            return item.name.toLowerCase().includes(query) || item.provider.toLowerCase().includes(query);
                        });

                        if (result.length !== 0) {
                            for (let i = 0; i < games.length; i++) {
                                games[i].style.display = 'none';
                            }

                            result.forEach((item) => {
                                let i = createGameItem(item);
                                let container = document.querySelector('#game-container');
                                i = container.appendChild(i);
                                results.push(i);

                                if (biggerGames.classList.contains('active')) {
                                    i.classList.add('col-12');
                                    i.classList.add('col-md-4');
                                    i.classList.add('col-xl-3');
                                } else {
                                    i.classList.add('col-6');
                                    i.classList.add('col-md-3');
                                    i.classList.add('col-xl-2');
                                    i.firstChild.firstChild.firstElementChild.classList.remove('lg');
                                    i.firstChild.firstChild.firstElementChild.classList.add('md');
                                }
                            });
                        }
                    }
                    notFoundMessage.style.display = found ? 'none' : '';
                    return 1;
                }
            </script>
        {/literal}
    </div>
    <div role="dialog" aria-modal="true" class="fade darkModal modal" tabindex="-1"
         style="padding-right: 3px;">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="embed-responsive">
                    <iframe scrolling="yes" class="embed-responsive-item" style="display: block;" src="#"></iframe>
                </div>
                <div class="modal-header">
                    <button class="expand" id="modal-fullscreen">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="expand-alt"
                             class="svg-inline--fa fa-expand-alt fa-w-14 " role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 448 512">
                            <path fill="currentColor"
                                  d="M212.686 315.314L120 408l32.922 31.029c15.12 15.12 4.412 40.971-16.97 40.971h-112C10.697 480 0 469.255 0 456V344c0-21.382 25.803-32.09 40.922-16.971L72 360l92.686-92.686c6.248-6.248 16.379-6.248 22.627 0l25.373 25.373c6.249 6.248 6.249 16.378 0 22.627zm22.628-118.628L328 104l-32.922-31.029C279.958 57.851 290.666 32 312.048 32h112C437.303 32 448 42.745 448 56v112c0 21.382-25.803 32.09-40.922 16.971L376 152l-92.686 92.686c-6.248 6.248-16.379 6.248-22.627 0l-25.373-25.373c-6.249-6.248-6.249-16.378 0-22.627z"></path>
                        </svg>
                    </button>
                    <button type="button" class="close" id="modal-close"><span aria-hidden="true">×</span><span
                                class="sr-only">Kapat</span></button>
                </div>
            </div>
        </div>
    </div>
    {literal}
        <script type="text/javascript">
            let dialog = document.querySelector('.darkModal.modal');
            let modalCloseButton = document.querySelector('#modal-close');
            let modalFullscreenButton = document.querySelector('#modal-fullscreen');

            function showModal(gameUrl){
                console.log(gameUrl);
                dialog.childNodes[1].childNodes[1].childNodes[1].childNodes[1].src = gameUrl;
                dialog.classList.add('show');

            }

			/* buttons */
            modalCloseButton.addEventListener('click', () => {
            	dialog.classList.remove('show');

				let iframe = dialog.childNodes[1].childNodes[1].childNodes[1].childNodes[1];

                if (iframe) {
                	iframe.src = '';
                }
			});

            modalFullscreenButton.addEventListener('click', () => {
                let elem = dialog.childNodes[1].childNodes[1].childNodes[1].childNodes[1];

                if (!document.fullscreenElement && !document.mozFullScreenElement &&
                    !document.webkitFullscreenElement && !document.msFullscreenElement) {
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.mozRequestFullScreen) {
                        elem.mozRequestFullScreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
            });

            function openGame(id){
                table_id = id;
                let game_url = '';
                $.ajax({
                    url:"/LiveCasino/Token/"+table_id,
                    success:function(response){
                        console.log(response.url);
                        if (response.code === "1") {
                            if(response.url === null || response.url === undefined || response.url == ''){
                                game_url = location.protocol + '//' + location.hostname + '/LiveCasino/notFound';
                            }else{
                                game_url = response.url;
                            }

                            if (window.innerWidth < 1200) {
                                window.open(game_url, "_blank");
                            }else{
                                showModal(game_url);
                            }
                        }
                    }
                });
            }
			
			function demoGame(id){
                table_id = id;
                let game_url = '';
                $.ajax({
                    url:"/LiveCasino/TwoWinDemo/"+table_id,
                    success:function(response){
                        console.log(response, response.url === null || response.url === undefined || response.url == '');
                        if (response.code === "1") {
                            if(response.url === null || response.url === undefined || response.url == ''){
                                game_url = location.protocol + '//' + location.hostname + '/LiveCasino/notFound';
                            }else{
                                game_url = response.url;
                            }

                            if (window.innerWidth < 1200) {
                                window.open(game_url, "_blank");
                            }else{
                                showModal(game_url);
                            }
                        }
                    }
                });
            }

            if (table_id !== '') {
                openGame(table_id);
            }
        </script>
    {/literal}
</section>
{php} include "content/dark-theme/view/dark_footer.php";{/php}