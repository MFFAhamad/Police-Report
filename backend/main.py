from flask import Flask, request, jsonify
import face_recognition
from werkzeug.utils import secure_filename
import numpy as np

app = Flask(__name__)

ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg'}


def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS


def recognize_face(image1, image2):
   
    face_1 = face_recognition.load_image_file(image1)
    face_2 = face_recognition.load_image_file(image2)

 
    face_1_encoding = face_recognition.face_encodings(face_1)
    face_2_encoding = face_recognition.face_encodings(face_2)


    if face_1_encoding and face_2_encoding:
   
        results = face_recognition.compare_faces(face_1_encoding, face_2_encoding[0])
        if results[0]:
            return "Person recognized.", True
        else:
            return "Person not recognized.", False
    else:
        return "No faces found in one or both images.", False


@app.route('/upload', methods=['POST'])
def upload_file():
  
    if 'id_image' not in request.files or 'person_image' not in request.files:
        return jsonify({"error": "Missing images in the request"}), 400

    id_image = request.files['id_image']
    person_image = request.files['person_image']

    if id_image.filename == '' or person_image.filename == '':
        return jsonify({"error": "No selected files"}), 400

    if id_image and allowed_file(id_image.filename) and person_image and allowed_file(person_image.filename):
 
        message, recognized = recognize_face(id_image, person_image)
        return jsonify({"message": message, "recognized": recognized}), 200
    else:
        return jsonify({"error": "File types not allowed"}), 400


if __name__ == '__main__':
    app.run(debug=True)
