const dino = document.getElementById("dino");
const cacti = document.querySelectorAll(".cactus");
cacti.forEach((cactus) => {
  spawnCactus(cactus);
});

let score = 0;
let highScore = 0;  
function updateScore() {
  score++;
  document.getElementById("score").textContent = score;
}

function jump() {
  if (dino.classList != "jump") {
    dino.classList.add("jump");

    setTimeout(function () {
      dino.classList.remove("jump");
      updateScore();
    }, 300);
  }
}

function spawnCactus() {
    const cactus = document.createElement("div");
    cactus.className = "cactus";
  
    const game = document.querySelector(".game");
    game.appendChild(cactus);
  
    setTimeout(function () {
      game.removeChild(cactus);
    }, 5000);
  }
  
  setInterval(function () {
    spawnCactus();
  }, 1000);

spawnCactus(); // Chama a função para posicionar o cacto inicialmente

function checkCollision() {
    let dinoTop = parseInt(window.getComputedStyle(dino).getPropertyValue("top"));
    let cactusLeft = parseInt(window.getComputedStyle(cactus).getPropertyValue("left"));
  
    if (cactusLeft < 50 && cactusLeft > 0 && dinoTop >= 140) {
      // Colisão detectada
      if (score > highScore) {
        // Se a pontuação atual for maior do que a maior pontuação registrada
        highScore = score; // Atualize a maior pontuação
        saveHighScore(); // Salve a maior pontuação no banco de dados
      }
      resetGame();
    }
  }
  
  function saveHighScore() {
    // Use uma requisição AJAX para enviar a maior pontuação para o servidor e salvá-la no banco de dados
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "home.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log("Maior pontuação salva com sucesso!");
        updateHighScore(); // Atualiza a pontuação exibida na página
        location.reload(); // Recarrega a página para exibir a pontuação atualizada
      }
    };
    xhr.send("pontuacao=" + highScore);
  }

function resetGame() {
  score = 0;    
  document.getElementById("score").textContent = score;

  // Remova todos os cactos do jogo
  const game = document.querySelector(".game");
  const cacti = document.querySelectorAll(".cactus");
  cacti.forEach((cactus) => {
    game.removeChild(cactus);
  });

  // Reinicie o jogo chamando spawnCactus() novamente
  spawnCactus();
}
function updateScore() {
    score++;
    document.getElementById("score").textContent = score;
  }
  
  // Função para buscar a pontuação atualizada do servidor
  function getHighScore() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "home.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        highScore = parseInt(xhr.responseText);
        if (!isNaN(highScore)) {
          document.querySelector(".high-score").textContent = "Maior Pontuação: " + highScore;
        }
      }
    };
    xhr.send();
  }

setInterval(function () {
  checkCollision();
}, 10);

document.addEventListener("keydown", function (event) {
  jump();
});
function updateHighScore() {
    const highScoreElement = document.getElementById("high-score");
    if (highScoreElement) {
      highScoreElement.textContent = "Maior Pontuação: " + highScore;
    }
  }
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Maior pontuação salva com sucesso!");
      updateHighScore(); // Atualiza a pontuação exibida na página
    }
  };  
getHighScore();