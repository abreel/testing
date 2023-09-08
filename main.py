import os
import re

# Define the directory path
directory_path = "/Users/Abi/Documents/GitHub/monicredit/tests/Unit/Controllers"

# Loop through the directory and count the total number of files
for root, dirs, files in os.walk(directory_path):
    for file_path in files:
        root_path = os.path.join(root, file_path)
        with open(root_path, "r") as file:
            content = file.read()

        splitted_text = content.split("<?php")[1].split("class")[0]

        # Define the pattern to match double new lines
        pattern = r"(\n\s*){2,}"

        # Use re.sub to replace matched patterns with a single new line
        updated_split = "\n" + re.sub(pattern, "\n", splitted_text) + "\n"
        updated_content = content.replace(splitted_text, updated_split)

        # Write the updated content back to the file
        with open(root_path, "w") as file:
            file.write(updated_content)

        print(
            f"Double new lines removed between <?php and class declarations for {root_path}."
        )
