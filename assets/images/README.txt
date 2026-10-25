EVENT IMAGES FOLDER
===================

This folder stores event images uploaded by administrators.

IMPORTANT:
- Add a file named "default-event.jpg" to this folder to use as the default event image
- Recommended dimensions: 800x600 pixels or 4:3 aspect ratio
- Accepted formats: JPG, PNG, GIF
- Maximum file size depends on your PHP configuration (default: 2MB)

If no default-event.jpg is provided, the system will gracefully handle missing images with the onerror attribute.

Uploaded event images will be saved with the format:
event_[timestamp]_[random].ext

Example: event_1699123456_7890.jpg

This folder should have write permissions for the web server to allow image uploads.
