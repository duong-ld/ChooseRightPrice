const elements = document.querySelectorAll.bind(document);
const element = document.querySelector.bind(document);

var answerCol = [1, 4, 7];
var answer;

const cleanup = () => {
  elements(".hidden").forEach(e => {
    e.classList.remove("hidden");
  })
  elements(".clicked").forEach(e => {
    e.classList.remove("clicked");
  })
}

const setup = (clickable) => {
  elements("#game div").forEach((e, index) => {
    e.innerHTML = index;
    if (index % 3 == 1) {
      e.classList.add("hidden");
    } else {
      e.onclick = () => {
        if (e.classList.contains("clicked")) {
          e.classList.remove("clicked");
        } else {
          if (elements(".clicked").length < clickable) {
            e.classList.add("clicked");
          }
        }
      }
    }
  });
}

const play = (clickable) => {
  let temp = Math.floor(Math.random() * 8);
  answer = answerCol[Math.floor(temp / 3)];

  cleanup();
  setup(clickable);
}

const check = () => {
  let win = false;
  const clicked = Array.from(elements(".clicked")).map(e => Number(e.innerHTML));
  for (let i = 0; i < clicked.length - 1; i++) {
    for (let j = i + 1; j < clicked.length; j++) {
      if ((clicked[i] + clicked[j]) / 2 == answer)
        win = true
    }
  }

  if (win) {
    // alert("Yes");
    $('#successModal').modal('show');
  } else {
    $('#failModal').modal('show');
  }

  Array.from(elements("#game div"))[answer].classList.add("clicked");
}