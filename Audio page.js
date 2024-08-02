const image = document.getElementById('cover');
const title = document.getElementById('music-title');
const artist = document.getElementById('music-artist');
const currentTimeEl = document.getElementById('current-time');
const durationEl = document.getElementById('duration');
const progress = document.getElementById('progress');
const playerProgress = document.getElementById('player-progress');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
const playBtn = document.getElementById('play');
const background = document.getElementById('bg-img');

const music = new Audio();

const songs = [
  {
    path: 'music01.mp3',
    displayName: 'The Silence',
    cover: 'music01.jpg',
    artist: 'Anonymous',
  },
  {
    path: 'music 02.mp3',
    displayName: 'The Healer',
    cover: 'music02.jpg',
    artist: 'Anonymous',
  },
  {
    path: 'music 03.mp3',
    displayName: 'Under Pain',
    cover: 'music03.jpg',
    artist: 'Anonymous',
  },
  {
    path: 'bones.mp3',
    displayName:'The Bones',
    cover:'bones.jpg',
    artist:'Maren Morris',
  },
  {
    path:'faded.mp3',
    displayName:'Faded',
    cover:'faded.jpg',
    artist:'Alan Walker',
  },
  {
    path:'scars.mp3',
    displayName:'Scars to Your Beautiful',
    cover:'scars.jpg',
    artist:'Alessia Cara',
  },
  {
    path:'thunder.mp3',
    displayName:'Thunder',
    cover:'thunder.jpg',
    artist:'Imagine Dragons',

  },
  {
    path:'who says.mp3',
    displayName:'Who Says',
    cover:'who says.jpg',
    artist:'Selena Gomez',
  },
];

let musicIndex=0;
let isPlaying=false;

function togglePlay(){
  if(isPlaying){
    pauseMusic();
  }else{
    playMusic();
  }
}

function playMusic(){
  isPlaying=true;
  playBtn.classList.replace('fa-play','fa-pause');
  playBtn.setAttribute('title','Pause');
  music.play();
}

function pauseMusic(){
  isPlaying=false;
  playBtn.classList.replace('fa-pause','fa-play');
  playBtn.setAttribute('title','Play');
  music.pause();
}

function loadMusic(song){
  music.src=song.path;
  title.textContent=song.displayName;
  artist.textContent=song.artist;
  image.src=song.cover;
  background.src=song.cover;
}

function changeMusic(direction){
  musicIndex=(musicIndex + direction + songs.length) % songs.length;
  loadMusic(songs[musicIndex]);
  playMusic();
}

function updateProgressBar(){
  const {duration, currentTime} = music;
  const progressPercent = (currentTime/duration)*100;
  progress.style.width='${progressPercent}%';

}

function setProgressBar(e){
  const width=playerProgress.clientWidth;
  const clickX=e.offsetX;
  music.currentTime=(clickX/width)*music.duration;
}

playBtn.addEventListener('click',togglePlay);
prevBtn.addEventListener('click',()=>changeMusic(-1));
nextBtn.addEventListener('click',()=>changeMusic(1));
music.addEventListener('ended',()=>changeMusic(1));
music.addEventListener('timeupdate',updateProgressBar);
playerProgress.addEventListener('click',setProgressBar);

loadMusic(songs[musicIndex]);