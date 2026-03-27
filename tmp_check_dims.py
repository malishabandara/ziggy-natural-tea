
from PIL import Image
try:
    img = Image.open(r'c:\xampp\htdocs\Ziggy-Natural-Tea\Ziggy-Natural-Tea\assets\logo.png')
    print(f"Dimensions: {img.size}")
except Exception as e:
    print(f"Error: {e}")
