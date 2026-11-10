<?php
include "init.php";
$page->title = "Bookshelf Renovation";
$page->wip = true;

ob_start();
?>

<h1>Bookshelf Wall Renovation</h1>
<p>Interactive 3D rendering of the planned media wall. Use mouse to orbit, scroll to zoom.</p>

<div id="bookshelf-canvas" style="width: 100%; height: 500px; border: 1px solid #ccc; margin: 1em 0;"></div>

<script type="importmap">
{
  "imports": {
    "three": "https://cdn.jsdelivr.net/npm/three@0.169.0/build/three.module.js"
  }
}
</script>

<script type="module">
import * as THREE from 'three';

const container = document.getElementById('bookshelf-canvas');
const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf0f0f0);

const camera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
camera.position.set(8, 4, 12);

const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(container.clientWidth, container.clientHeight);
container.appendChild(renderer.domElement);

const ambient = new THREE.AmbientLight(0xffffff, 0.6);
scene.add(ambient);
const dir = new THREE.DirectionalLight(0xffffff, 0.8);
dir.position.set(5, 10, 7);
scene.add(dir);

// Dimensions in feet (approx from guitar reference ~40")
const width = 12;   // ~144"
const height = 8;   // ~96"
const depth = 1.2;  // ~14.4"

const white = new THREE.MeshLambertMaterial({ color: 0xf5f5f5 });
const shelfMat = new THREE.MeshLambertMaterial({ color: 0xffffff });
const cabinetMat = new THREE.MeshLambertMaterial({ color: 0xeeeeee });
const accent = new THREE.MeshLambertMaterial({ color: 0x333333 });

// Base cabinets
const baseH = 2.5;
const base = new THREE.Mesh(new THREE.BoxGeometry(width, baseH, depth), cabinetMat);
base.position.set(0, baseH / 2, 0);
scene.add(base);

// Cabinet doors suggestion
for (let i = -2; i <= 2; i++) {
  const door = new THREE.Mesh(new THREE.BoxGeometry(1.8, baseH - 0.2, 0.05), white);
  door.position.set(i * 2.2, baseH / 2, depth / 2 + 0.01);
  scene.add(door);
}

// Mid media shelf
const midY = baseH + 0.1;
const midShelf = new THREE.Mesh(new THREE.BoxGeometry(width, 0.1, depth), shelfMat);
midShelf.position.set(0, midY, 0);
scene.add(midShelf);

// Turntable
const tt = new THREE.Mesh(new THREE.BoxGeometry(1.5, 0.15, 1.2), accent);
tt.position.set(0, midY + 0.2, 0);
scene.add(tt);

// Speakers
const spkGeo = new THREE.BoxGeometry(0.6, 0.8, 0.5);
const leftSpk = new THREE.Mesh(spkGeo, accent);
leftSpk.position.set(-2.5, midY + 0.5, 0);
scene.add(leftSpk);
const rightSpk = new THREE.Mesh(spkGeo, accent);
rightSpk.position.set(2.5, midY + 0.5, 0);
scene.add(rightSpk);

// Upper structure
const upperStart = midY + 0.8;
const upperH = height - upperStart;

// Side shelves frames
function makeShelfBay(x, w) {
  const frame = new THREE.Mesh(new THREE.BoxGeometry(w, upperH, depth), white);
  frame.position.set(x, upperStart + upperH / 2, 0);
  scene.add(frame);
  // shelves
  for (let s = 0; s < 4; s++) {
    const sh = new THREE.Mesh(new THREE.BoxGeometry(w - 0.2, 0.05, depth - 0.1), shelfMat);
    sh.position.set(x, upperStart + 0.3 + s * (upperH / 5), 0);
    scene.add(sh);
  }
}
makeShelfBay(-4.5, 3);
makeShelfBay(4.5, 3);

// Central TV recess
const tvW = 5;
const tvH = 3;
const tvFrame = new THREE.Mesh(new THREE.BoxGeometry(tvW, tvH, 0.2), white);
tvFrame.position.set(0, upperStart + 1.5, -depth / 2 + 0.1);
scene.add(tvFrame);
const tv = new THREE.Mesh(new THREE.BoxGeometry(tvW - 0.3, tvH - 0.3, 0.1), accent);
tv.position.set(0, upperStart + 1.5, -depth / 2 + 0.15);
scene.add(tv);

// Top shelf
const top = new THREE.Mesh(new THREE.BoxGeometry(width, 0.15, depth), white);
top.position.set(0, height - 0.1, 0);
scene.add(top);

// Simple orbit controls
let isDragging = false;
let prevX = 0, prevY = 0;
container.addEventListener('pointerdown', e => { isDragging = true; prevX = e.clientX; prevY = e.clientY; });
container.addEventListener('pointerup', () => isDragging = false);
container.addEventListener('pointerleave', () => isDragging = false);
container.addEventListener('pointermove', e => {
  if (!isDragging) return;
  const dx = e.clientX - prevX;
  const dy = e.clientY - prevY;
  prevX = e.clientX;
  prevY = e.clientY;
  const spherical = new THREE.Spherical().setFromVector3(camera.position);
  spherical.theta -= dx * 0.01;
  spherical.phi -= dy * 0.01;
  spherical.phi = Math.max(0.1, Math.min(Math.PI - 0.1, spherical.phi));
  camera.position.setFromSpherical(spherical);
  camera.lookAt(0, height / 2, 0);
});
container.addEventListener('wheel', e => {
  e.preventDefault();
  camera.position.multiplyScalar(1 + e.deltaY * 0.001);
});

function animate() {
  requestAnimationFrame(animate);
  camera.lookAt(0, height / 2 - 0.5, 0);
  renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
  camera.aspect = container.clientWidth / container.clientHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(container.clientWidth, container.clientHeight);
});
</script>

<h2>Build Notes</h2>
<ul>
  <li><strong>Dimensions (approx):</strong> 12 ft wide × 8 ft high × 14 in deep. Scaled from the hanging acoustic guitar (~40 in overall length). Confirm on-site before cutting.</li>
  <li><strong>Central bay:</strong> Recess sized for 65–75 in TV (~57–66 in wide). Leave 3–4 in clearance each side. Wall-mount or sit on mid shelf.</li>
  <li><strong>Mid level:</strong> Open shelf for turntable (center) and speakers (flanking). Depth sufficient for components + cables. Room for AV switches/receiver.</li>
  <li><strong>Lower:</strong> Full-width cabinets with louvered doors matching existing style. Secure to wall studs (anti-tip).</li>
  <li><strong>Upper flanks:</strong> Adjustable bookshelves (shelf pins). ~12 in usable depth for books.</li>
  <li><strong>Materials:</strong> 3/4 in plywood shelves and dividers, paint-grade. Match existing white finish. Face frames optional for cleaner look.</li>
  <li><strong>Electrical:</strong> Outlets behind TV and media shelf. Cable channels or grommets. Consider LED strip lighting on shelves.</li>
  <li><strong>Child safety:</strong> Solid wall attachment, no tip-over risk, durable finish, lockable cabinets if needed for small items.</li>
  <li><strong>Approach:</strong> Modify existing unit where practical or rebuild modular sections. Keep construction simple—no unnecessary complexity.</li>
</ul>

<p><em>Model is approximate for visualization. Final dimensions and details to be confirmed during planning.</em></p>

<?php $main = ob_get_clean(); ?>
<?php include "layout.php"; ?>
