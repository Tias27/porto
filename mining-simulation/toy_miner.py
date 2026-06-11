import hashlib
import time


DIFFICULTY = 5
BLOCK_DATA = "belajar proof of work"


def sha256(text: str) -> str:
    return hashlib.sha256(text.encode("utf-8")).hexdigest()


def mine(block_data: str, difficulty: int) -> dict:
    prefix = "0" * difficulty
    nonce = 0
    start = time.time()

    while True:
        payload = f"{block_data}:{nonce}"
        block_hash = sha256(payload)

        if block_hash.startswith(prefix):
            elapsed = time.time() - start
            return {
                "block_data": block_data,
                "difficulty": difficulty,
                "nonce": nonce,
                "hash": block_hash,
                "elapsed": elapsed,
                "hashrate": nonce / elapsed if elapsed > 0 else 0,
            }

        nonce += 1


if __name__ == "__main__":
    result = mine(BLOCK_DATA, DIFFICULTY)

    print("=== Simulasi Mining / Proof of Work ===")
    print(f"Data       : {result['block_data']}")
    print(f"Difficulty : {result['difficulty']}")
    print(f"Nonce      : {result['nonce']}")
    print(f"Hash       : {result['hash']}")
    print(f"Waktu      : {result['elapsed']:.2f} detik")
    print(f"Hashrate   : {result['hashrate']:.2f} hash/detik")
