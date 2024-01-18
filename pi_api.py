import json
from flask import Flask, request, jsonify
from datetime import datetime
import subprocess
import re

app = Flask(__name__)
app.config["JSONIFY_PRETTYPRINT_REGULAR"] = True

#/client?ip=192.168.1.151
@app.route('/client', methods=['GET'])
def get_client():
    client_ip = request.args.get('ip')
    result={}
    time_now = datetime.now().strftime("%I:%M %m/%d/%Y")
    cmd = ['arp', '-na', client_ip]
    proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    o, e = proc.communicate()
    arp_result = o.decode('ascii')

    sql_query = f'''SELECT * FROM queries WHERE client = '{client_ip}' ORDER BY id DESC LIMIT 20;'''

    # pihole_cmd = f'''sqlite3 /etc/pihole/pihole-FTL.db "{sql_query}"'''

    cmd = ['sqlite3', '/etc/pihole/pihole-FTL.db', sql_query]
    proc = subprocess.Popen(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    o, e = proc.communicate()
    query_result = o.decode('ascii').strip()
    query_result_parsed = ''
    for query in query_result.split('\n'):
        #print("query:   ",query)
        #print(re.split('\|',query))
        q = re.split('\|',query)
        if q[3] == '2' or q[3] == '3':
            query_result_parsed += f'<font color="green">{q[4]}</font><br>'
            # query_result_parsed += f'<font color="green">{q[2]} , {q[3]} , {q[4]}</font><br>'
        else:
            query_result_parsed += f'<font color="red">{q[4]}</font><br>'
            # query_result_parsed += f'<font color="red">{q[2]} , {q[3]} , {q[4]}</font><br>'

    return jsonify({"arp_result":arp_result.replace('\n','<br>'),
        "query_result": query_result_parsed,
        # query_result.replace('\n','<br>'),
        "time":time_now})

if __name__ == "__main__":
    app.run(host="0.0.0.0",port=5000)
