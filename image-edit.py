from PIL import Image

def resize_image_fixed(input_path: str, output_path: str, width: int, height: int):
    with Image.open(input_path) as img:
        resized_img = img.resize((width, height), Image.LANCZOS)
        resized_img.save(output_path)
        print(f"Image resized to {width}x{height} and saved to '{output_path}'")

# ── Configuration ──────────────────────────────────────────
INPUT_IMAGE  = "C:/Users/AFS/Desktop/clients/client_fao_resized.png" 
OUTPUT_IMAGE = "C:/Users/AFS/Desktop/clients/client_fao_resized.png"
TARGET_WIDTH  = 800
TARGET_HEIGHT = 400
# ───────────────────────────────────────────────────────────

resize_image_fixed(INPUT_IMAGE, OUTPUT_IMAGE, TARGET_WIDTH, TARGET_HEIGHT)