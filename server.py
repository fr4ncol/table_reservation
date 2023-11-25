"""
Basic flask backend table reservation handler

@author Franciszek Plisz
@author Dawid Ciemała
"""

from flask import Flask, render_template, request, jsonify
import logging

# Basic configuration
app = Flask(__name__)
logging.basicConfig(level=logging.DEBUG) 

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/submit_reservation', methods=['POST'])
def submit_reservation():
    # Get reservation data from the request
    name = request.form.get('name')
    email = request.form.get('email')
    party_size = request.form.get('partySize')
    reservation_date = request.form.get('reservationDate')
    reservation_time = request.form.get('reservationTime')
    app.logger.debug(name, email, party_size, reservation_date, reservation_time)
    # Here, you can perform additional actions like storing the reservation data in a database

    # Return a simple response (you might want to send a more meaningful response in a real application)
    return jsonify({'status': 'success', 'message': 'Reservation submitted successfully'})

if __name__ == '__main__':
    app.run(debug=True)