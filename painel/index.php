<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zorika Painel</title>
  <link rel="stylesheet" type="text/css" href="css/painel.css">
</head>
<body>

<!-- aqui começa os card's de paciente, o qual exibe o ultimo chamado -->
<div class="section adjustable-div">
  <h2 style="text-align: center; color: #ecf0f1;">Último Paciente Chamado</h2>
  <div id="pacientes">
    <div class="paciente-card">
      <!-- Conteúdo da div paciente-card -->
    </div>
  </div>
  <!-- aqui começa os card's de SENHA, o qual exibe o ultimo chamado -->
  <h2 style="text-align: center; color: #ecf0f1;">Última Senha Chamada</h2>
  <div id="chamadas1">
    <div class="chamada">
            <!-- Conteúdo da div chamada referente as senhas comum e preferencial -->
    </div>
  </div>
  <!-- aqui termina os card's de SENHAS, o qual exibe o ultimo chamado -->

</div>

<!-- aqui termina os card's de paciente, o qual exibe o ultimo chamado -->

<!-- aqui começa o video central da pagina, voltado para o marketing da empresa -->
<div class="section adjustable-div">
  <div id="videoFrame">
    <video id="videoContainer"  autoplay>
  <source src="videos/marq.mp4" type="video/mp4">
</video>
  </div>
</div>


<script>
var videoContainer = document.getElementById('videoContainer');
var videos = ["videos/marq.mp4", "videos/endo.mp4", "videos/cbsb.mp4"];
var currentVideo = 0;

videoContainer.onended = function() {
    currentVideo++;
    if(currentVideo >= videos.length) {
        currentVideo = 0; 
    }
    videoContainer.src = videos[currentVideo];
    videoContainer.play();
};
</script>




<!-- aqui termina o video central da pagina, voltado para o marketing da empresa -->

<!-- aqui começa os card's de HISTORICO, o qual ignora o primeiro de cada lado e mostra de forma misturada os 5 primeiros restantes -->
<div class="historico">
</div>
<!-- aqui termina os card's de HISTORICO, o qual ignora o primeiro de cada lado e mostra de forma misturada os 5 primeiros restantes -->

<!-- aqui começa os card's de Fade-in, está invisivel e só aparece com uma informação nova é adicionada no banco de dados-->
<div class="ultima-fade-in">
</div>
<!-- aqui termina os card's de Fade-in, está invisivel e só aparece com uma informação nova é adicionada no banco de dados-->

<script src="js/jquery.js"></script>
<script src="js/ult-paciente.js"></script>
<script src="js/ult-senha.js"></script>
<script src="js/historico.js"></script>
<script src="js/voz.js"></script>

</body>
</html>