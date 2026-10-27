"""Encode rendered Full HD frames as a seamless, muted 24 fps hero loop.
Requires FFmpeg with libx264 and Python Pillow (AVIF/WebP support).
"""
import argparse
from pathlib import Path
import subprocess
import tempfile
from PIL import Image
parser = argparse.ArgumentParser()
parser.add_argument('--frames', type=Path, required=True)
parser.add_argument('--poster', type=Path)
args = parser.parse_args()
root = Path(__file__).resolve().parents[1]
video_dir = root / 'assets/video'
image_dir = root / 'assets/precision'
frames = [args.frames / f'frame-{n:04d}.png' for n in range(1, 146, 3)]
for frame in frames:
    if not frame.is_file():
        raise FileNotFoundError(f'Render is incomplete: {frame}')
with tempfile.TemporaryDirectory(prefix='mc-hero-encode-') as directory:
    # Include two frames from the next cycle for interpolation lookahead.
    for index, frame in enumerate(frames + frames[1:3]):
        (Path(directory) / f'{index:04d}.png').symlink_to(frame.resolve())
    subprocess.run([
        'ffmpeg', '-hide_banner', '-y', '-threads', '4', '-framerate', '8',
        '-i', f'{directory}/%04d.png', '-filter_threads', '4', '-vf',
        'minterpolate=fps=24:mi_mode=mci:mc_mode=aobmc:me_mode=bidir:vsbmc=1',
        '-t', '6', '-an', '-c:v', 'libx264', '-preset', 'slow', '-crf', '24',
        '-threads', '4', '-pix_fmt', 'yuv420p', '-movflags', '+faststart',
        '-metadata', 'comment=Original illustrative 3D robotic finishing cell; not a specific customer installation.',
        str(video_dir / 'robotic-cell-1080.mp4')
    ], check=True)
subprocess.run([
    'ffmpeg', '-hide_banner', '-y', '-threads', '4', '-i', str(video_dir / 'robotic-cell-1080.mp4'),
    '-vf', 'scale=1280:720', '-filter_threads', '4', '-an', '-c:v', 'libx264',
    '-preset', 'slow', '-crf', '25', '-threads', '4', '-pix_fmt', 'yuv420p',
    '-movflags', '+faststart', str(video_dir / 'robotic-cell-720.mp4')
], check=True)
image = Image.open(args.poster or frames[0]).convert('RGB')
for width in [480, 720, 960, 1600, 1920]:
    variant = image.copy()
    variant.thumbnail((width, width * 3))
    variant.save(image_dir / f'robotic-cell-{width}.avif', 'AVIF', quality=50, speed=6)
    variant.save(image_dir / f'robotic-cell-{width}.webp', 'WEBP', quality=80, method=6)
print('Encoded Full HD and 720p, 6 seconds / 24 fps, no audio; responsive posters generated.')
