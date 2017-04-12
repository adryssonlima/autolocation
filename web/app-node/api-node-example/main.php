<?php
/* @var $this View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Agente;
use app\models\CentralNotificacoes;
use app\models\Sipfriends;
use app\models\VariaveisGlobais;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$user = Yii::$app->user->identity;
$flagAgente = Agente::verificaAgenteLogado($user->name);

$grupo_user = $user->grupo;

if ($user && $grupo_user == 'Agente' && $flagAgente == false) {
    return Yii::$app->response->redirect("site/login-agente");
}


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="/js/cookies/js.cookie.js"></script>
        <style>
            /* Let's get this party started */
            ::-webkit-scrollbar {
                width: 10px;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                /*-webkit-border-radius: 10px;*/
                border-radius: 20px;
                background: #232A2F;
            }
            ::-webkit-scrollbar-thumb:window-inactive {
                background: #2D353C;
            }

        </style>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script>
            var InitialURL = '<?= Yii::$app->request->baseUrl ?>';
            var UserGroup = "<?= Yii::$app->user->identity->grupo ?>";
        </script>
        <?php $this->head() ?>
    </head>
    <body>

        <?php $this->beginBody() ?>
        <div class="wrap">

            <div id="topbar">
                <?= $this->render("componentes/navbar.php"); ?>
            </div>

            <!--Inicio Menu-->
            <script src="<?= Yii::$app->request->baseUrl ?>/js/jquery.min.js"></script>
            <?php

            function checaUrl($url) {
                if ($url == Yii::$app->controller->id) {
                    return "active";
                }
            }

            function checaRbac($controler) {
                if (Yii::$app->user->can($controler)) {
                    return 1;
                } else {
                    return 0;
                }
            }

            $id_agente = Yii::$app->user->identity->id;
            $grupo = Yii::$app->authManager->getRolesByUser($id_agente);
            $grupo_name = array_values($grupo)[0]->name;

            $dashboard = "Dashboard-$grupo_name";

            $menu = [
                    ["label" => $dashboard, "icone" => "fa-laptop", "url" => Yii::$app->homeUrl . 'dashboard', "opt" => checaUrl('dashboard'), 'acesso' => 1],
                    ["label" => "Ramais", "icone" => "fa-phone", "url" => Yii::$app->homeUrl . 'ramal', "opt" => checaUrl('ramal'), 'acesso' => checaRbac("/ramal/*")],
                    ["label" => "VoiceMail", "icone" => "fa-bullhorn", "url" => Yii::$app->homeUrl . 'voicemail', "opt" => checaUrl('voicemail'), 'acesso' => checaRbac("/voicemail/*")],
                    ["label" => "Bloqueados", "icone" => "fa-user-times", "url" => Yii::$app->homeUrl . 'bloqueados', "opt" => checaUrl('bloqueados'), 'acesso' => checaRbac("/bloqueados/*")],
                    ["label" => "Gravações", "icone" => "fa-video-camera", "url" => Yii::$app->homeUrl . 'gravacoes', "opt" => checaUrl('gravacoes'), 'acesso' => checaRbac("/gravacoes/*")],
                    ["label" => "Fax", "icone" => "fa-fax", "url" => Yii::$app->homeUrl . 'fax', "opt" => checaUrl('fax'), 'acesso' => checaRbac("/fax/*")],
                    ["label" => "Filas", "icone" => "fa-bars", "url" => Yii::$app->homeUrl . 'filas', "opt" => checaUrl('filas'), 'acesso' => checaRbac("/filas/*")],
                    ["label" => "Siga-me", "icone" => "fa-share", "url" => Yii::$app->homeUrl . 'sigame', "opt" => checaUrl('sigame'), 'acesso' => checaRbac("/sigame/*")],
                    ["label" => "Agentes", "icone" => "fa-user", "url" => Yii::$app->homeUrl . 'agente', "opt" => checaUrl('agente'), 'acesso' => checaRbac("/agente/*")],
                    ["label" => "Motivos de pausa", "icone" => "fa-pause", "url" => Yii::$app->homeUrl . 'motivos-pausa', "opt" => checaUrl('motivos-pausa'), 'acesso' => checaRbac("/motivos-pausa/*")],
                    ["label" => "Auditoria", "icone" => "fa-eye", "url" => Yii::$app->homeUrl . 'auditoria', "opt" => checaUrl('auditoria'), 'acesso' => checaRbac("/auditoria/*")],
//              ["label" => "Grupos de usuários", "icone" => "fa fa-users", "url" => Yii::$app->homeUrl.'papeis/index', "opt" => checaUrl('papeis'), 'acesso' => checaRbac("/papeis/*")],
                ["label" => "Painel de filas", "icone" => "fa-television", "url" => Yii::$app->homeUrl . 'painel-filas', "opt" => checaUrl('painel-filas'), 'acesso' => checaRbac("/painel-filas/*")],
                    ["label" => "Painel de ramais", "icone" => "fa fa-list-alt", "url" => Yii::$app->homeUrl . 'painel-ramais', "opt" => checaUrl('painel-ramais'), 'acesso' => checaRbac("/painel-ramais/*")],
                    ["label" => "Rotas Entrantes", "icone" => "fa fa-arrow-circle-left", "url" => Yii::$app->homeUrl . 'rotas-entrantes', "opt" => checaUrl('rotas-entrantes'), 'acesso' => checaRbac("/rotas-entrantes/*")],
                    ["label" => "Troncos IAX", "icone" => "fa fa-external-link", "url" => Yii::$app->homeUrl . 'troncos', "opt" => checaUrl('troncos'), 'acesso' => checaRbac("/troncos/*")],
                    ["label" => "Contextos especiais", "icone" => "fa fa-pencil-square-o", "url" => Yii::$app->homeUrl . 'exten-module', "opt" => checaUrl('exten-module'), 'acesso' => checaRbac("/exten-module/*")],
                    ["label" => "Configurações Asterisk", "icone" => "fa fa-asterisk", "url" => Yii::$app->homeUrl . 'configuracoes-asterisk', "opt" => checaUrl('configuracoes-asterisk'), 'acesso' => checaRbac("/configuracoes-asterisk/*")],
                    ["label" => "Configurações", "icone" => "fa fa-cogs", "url" => Yii::$app->homeUrl . 'configuracoes', "opt" => checaUrl('configuracoes'), 'acesso' => checaRbac("/configuracoes/*")],
                    ["label" => "Controle de usuário", "icone" => "fa-user-plus", "url" => Yii::$app->homeUrl . 'users', "opt" => checaUrl('users'), 'acesso' => checaRbac("/users/*")],
                    ["label" => "Notificações", "icone" => "fa fa-bell", "url" => Yii::$app->homeUrl . 'central-notificacoes', "opt" => checaUrl('central-notificacoes'), 'acesso' => checaRbac("/central-notificacoes/*")],
                    ["label" => "Logs", "icone" => "fa fa-file-text-o", "url" => Yii::$app->homeUrl . 'motor-log/index', "opt" => checaUrl('motor-log'), 'acesso' => checaRbac("/motor-log/*")],
                    ["label" => "Relatórios", "icone" => "fa fa-file-text-o", "url" => Yii::$app->homeUrl . 'relatorios', "opt" => checaUrl('relatorios'), 'acesso' => checaRbac("/relatorios/*")],
                    ["label" => "SMS", "icone" => "fa fa-envelope-o", "url" => Yii::$app->homeUrl . 'sms/index', "opt" => checaUrl('sms'), 'acesso' => checaRbac("/sms/*")],
                    ["label" => "Permissões", "icone" => "fa fa-users", "url" => Yii::$app->homeUrl . 'admin/role', "opt" => checaUrl('role'), 'acesso' => checaRbac("/admin/role/*")]
            ];


            echo $this->render("componentes/menu.php", ["menu" => $menu]);
            ?>


            <!--Fim Menu-->
            <!--Faz a importação dos gráficos-->
            <script>
            var filaGlobal = '<?= explode(",", Yii::$app->request->get('fila'))[0]; ?>';
            var todas_filas = '<?php
            $filas = explode(",", Yii::$app->request->get('fila'));
            $index = 0;
            foreach ($filas as $item) {
                $item = trim($item);
                if ($index == 0) {
                    echo "$item";
                    $index = 1;
                } else {
                    echo ",$item";
                }
            }
            ?>';

            </script>

            <div class="container">
                <?php
//                Breadcrumbs::widget([
//                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//                ])
                ?>

                <!--Implementação para unico modal com form em gii-->
                <script>
                    var notification;
                    var baseURL = "<?= Url::to("@web/img/notify.png") ?>";
                    // request permission on page load
                    document.addEventListener('DOMContentLoaded', function() {
                        if (!Notification) {
                            alert('Desktop notifications not available in your browser. Try Chromium.');
                            return;
                        }

                        if (Notification.permission !== "granted")
                            Notification.requestPermission();
                    });
                    function notificacao(titulo, msg, ico = baseURL) {
                        if (habilita_notificacoes) {
                            setTimeout(function() {
                                if (Notification.permission !== "granted")
                                    Notification.requestPermission();

                                else if (Cookies.get('notificationTitle') != titulo && Cookies.get('notificationMsg') != msg) {
                                    Cookies.set('notificationTitle', titulo);
                                    Cookies.set('notificationMsg', msg);

                                    notification = new Notification(titulo, {
                                        icon: ico,
                                        body: msg
                                    });
                                    notification.onclick = function() {
                                        this.close();
                                    };
                                }
                            }, Math.random());
                    }
                    }

                    function ModalAjax(url, titulo) {
                        $.ajax({
                            url: '<?php echo Yii::$app->request->baseUrl ?>' + url,
                            type: 'post',
                            data: {
                                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
                            },
                            success: function(data) {
                                $(".modal-conteudo").html(data);
                                lancaModal(titulo, data);
                            },
                            error: function() {
                                console.log("ERROR");
                            }
                        });
                    }
                </script>
                <?php
                Modal::begin([
                    'header' => '<span class="modal-titulo"></span>',
                    'id' => 'modal'
                ]);

                echo "<span class='modal-conteudo'></span>";

                Modal::end();
                ?>
                <?= $content ?>

            </div>

        </div>



        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage() ?>
<script src="/js/socket.io-1.4.5.js"></script>
<script>
                    var notificacoes = JSON.parse(<?= json_encode(CentralNotificacoes::findNotificacoes(Yii::$app->user->identity->ramal)) ?>);
                    var habilita_notificacoes = notificacoes[0][1];
                    var ligacoes_recebidas = notificacoes[1][1];
                    var ligacoes_realizadas = notificacoes[2][1];
                    var notificacoes_voicemails = notificacoes[3][1];
                    var notificacoes_asterisk = notificacoes[4][1];
                    var notificacoes_ramais = notificacoes[5][1];
                    var ip = "<?= VariaveisGlobais::getParametro("IP") ?>";

                    var ramal = "<?= Yii::$app->user->identity->ramal ?>";
                    if (ramal > 0 && window.location.href.split("/")[3] !== "painel" && false) {
                        var ramais = <?= json_encode(ArrayHelper::map(Sipfriends::find()->all(), "name", "callerid")) ?>;
                        $('.fila-painel-item').click(function() {
                            monta_cards(cardsGlobal);
                            filaGlobal = $(this).html();
                        });
                        //var socket = io.connect('http://' + ip + ':8000');
                        //socket.emit("login", "testeteste");
                        var tempoRamal = [];
                        var unique = "";
                        var duration = "";
                        var billsec = "";
                        var nome = "";
                        var exten = "";
                        socket.on("data", function(data) {
                            //console.log(data);
                            //Eventos do sistema

                            //Eventos do asterisk
                            if (notificacoes_asterisk) {
                                if (data.event == "Shutdown" && data.restart == "False") {
                                    notificacao("Asterisk está offline", "As ligações estão indisponíveis no momento");
                                }
                                if (data.event == "Shutdown" && data.restart == "True") {
                                    notificacao("Asterisk está sendo reiniciado", "As ligações podem ficar indisponíveis por alguns segundos");
                                }
                                if (data.event == "FullyBooted") {
                                    notificacao("Asterisk está online", "As ligações já podem ser realizadas normalmente");
                                }
                            }

                            //Evento de ramais
                            if (notificacoes_ramais) {
//                                    if (data.event == "PeerStatus" && data.peer == "SIP/" + ramal && data.peerstatus == "Registered") {
//                                        notificacao("Ramal foi registrado", "Seu ramal foi registrado no IP\n" + data.address);
//                                    }
                                if (data.event == "PeerStatus" && data.peer == "SIP/" + ramal && data.peerstatus == "Unregistered") {
                                    notificacao("Ramal desconectado", "A conexão com seu ramal foi perdida\nCausa: " + data.cause);
                                }
                            }

                            //Ligacoes discadas
                            if (ligacoes_realizadas) {
                                if (data.event == "CEL" && data.eventname == "CHAN_START") {
                                    if (unique != data.linkedid && data.calleridnum == ramal && data.exten != "s") {
                                        unique = data.linkedid;
                                        if (ramais[ data.exten.toString()] == undefined) {
                                            nome = data.exten;
                                        } else {
                                            nome = ramais[ data.exten.toString()];
                                            nome = nome.substring(1, nome.indexOf('" <'));
                                        }
                                        exten = data.exten;
                                        duration = data.eventtime;
                                        notificacao("Ligando para " + nome, data.exten, "/img/dial/discando.png");
                                    }
                                }

                                //Ligacoes conectadas
                                if (data.event == "CEL" && data.eventname == "BRIDGE_ENTER" && data.calleridnum == ramal) {
                                    billsec = data.eventtime;
                                    notification.close();
                                    notificacao("Ligação em execução", nome + " - " + exten, "/img/dial/conectada.png");
                                }
                            }

                            //Ligacoes recebidas
                            if (ligacoes_recebidas) {
                                if (data.event == "CEL" && data.eventname == "CHAN_START") {
                                    if (unique != data.linkedid && data.exten == ramal) {
                                        duration = data.eventtime;
                                        billsec = "";
                                        unique = data.linkedid;
                                        nome = data.calleridname;
                                        exten = data.calleridnum;
                                        notificacao("Recebendo ligação de " + data.calleridname, data.calleridnum, "/img/dial/recebida.png");
                                    }
                                }
                            }

                            //Fim da ligacao
                            if (ligacoes_recebidas || ligacoes_realizadas) {
                                //console.log(data);
                                if (data.event == "CEL" && (data.eventname == "CHAN_END" || data.eventname == "APP_END")) {
                                    if (data.linkedid == unique && data.calleridnum == ramal) {
                                        if (billsec == "") {
                                            billsec = data.eventtime;
                                        }//(Outgoing Line)
                                        var date1 = new Date(billsec);
                                        var date2 = new Date(data.eventtime);
                                        var date3 = new Date(duration);
                                        billsec = "";
                                        duration = "";
                                        tempoligacao = Math.abs(date1.getTime() - date2.getTime()) / 1000;
                                        tempochamado = Math.abs(date3.getTime() - date1.getTime()) / 1000;
                                        if (isNaN(tempoligacao)) {
                                            tempoligacao = "Ligação perdida";
                                        } else {
                                            tempoligacao = "Tempo em ligação " + tempoligacao + "s";
                                        }
                                        notificacao("Fim da ligação", "Tempo de chamado " + tempochamado + "s\n" + tempoligacao, "/img/dial/fim.png");
                                    }
                                    var aux = window.location.pathname.split("/");
                                    var grupo = "<?= $grupo_user ?>";
                                    if (aux[1] === 'dashboard' && grupo === 'Agente') {
                                        location.reload();
                                    }
                                }
                            }

                            //Notificação de Voicemail
                            if (notificacoes_voicemails) {
                                if (data.event == "MessageWaiting" && data.mailbox == ramal + "@LOCAL") {
                                    notificacao("Novo Voicemail de " + data.calleridname, data.calleridnum, "/img/voicemail_icon.png");
                                }
                            }

                            //Carregamento da chipeira da dashboard admin
                            if (data.event == "CEL" && UserGroup == "Admin" && data.channel.indexOf("SIP") == -1) {
                                carrega_chipeira();
                            }


                        });
                    }


                    //var audit = io.connect('http://' + ip + ':7300');
                    var user = "<?= Yii::$app->user->identity->name; ?>";
                    var email = "<?= Yii::$app->user->identity->email; ?>";
                    var allUrl = window.location.href;

                    navigator.sayswho = (function() {
                        var ua = navigator.userAgent, tem,
                                M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
                        if (/trident/i.test(M[1])) {
                            tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                            return 'IE ' + (tem[1] || '');
                        }
                        if (M[1] === 'Chrome') {
                            tem = ua.match(/\b(OPR|Edge)\/(\d+)/);
                            if (tem != null)
                                return tem.slice(1).join(' ').replace('OPR', 'Opera');
                        }
                        M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
                        if ((tem = ua.match(/version\/(\d+)/i)) != null)
                            M.splice(1, 1, tem[1]);
                        return M.join(' ');
                    })();
                    var plataforma = navigator.platform;
                    //audit.emit("data",[user,email,ramal,allUrl,navigator.sayswho,plataforma,screen.width+"x"+screen.height]);


</script>
