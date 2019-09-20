#!/usr/bin/env python

import sys
import json
import requests

class Fogbow():
	
	def __init__(self, username, password, tenant_id, project_id):
		self.username = username
		self.password = password
		self.tenant_id = tenant_id
		self.project_id = project_id
		#self.site = 'atm-test-site1.lsd.ufcg.edu.br'
		#self.cloud = 'cloud4'
		#self.endpoint = 'services-atm-test-site1.lsd.ufcg.edu.br'
		self.site = 'atm-prod.lsd.ufcg.edu.br'
		self.cloud = 'prod'
		self.endpoint = 'services-atm-prod.lsd.ufcg.edu.br'

	def get_images(self, param):
		# Get the Token
		header = {'Accept': 'application/json',
				  'Fogbow-User-Token': self.get_token()}

		# And get the images
		res = []
		url = 'https://%s/fns/images/%s/%s' % (self.endpoint, self.site, self.cloud)
		response = requests.get(url, headers=header)
		response.raise_for_status()
		return response.json()

	def get_token(self):
		# First get the publicKey of the FNS
		url = 'https://%s/fns/publicKey' % self.endpoint
		response = requests.get(url)
		public_key = response.json()['publicKey']

		url = 'https://%s/as/tokens' % self.endpoint
		header = {'Accept': 'application/json',
				  'Content-Type': 'application/json'}
		data = {
					"publicKey": public_key,
					"credentials":
					{
						"username": self.username,
						"password": self.password,
						"domain": self.tenant_id,
						"projectname": self.project_id
					}
		}
		response = requests.post(url, headers=header, data=json.dumps(data))
		response.raise_for_status()
		return response.json()['token']


if __name__ == "__main__":
    param = "images"
    if len(sys.argv) > 1:
        param = sys.argv[1]
		
	if len(sys.argv) > 5:
		username = sys.argv[2]
		password = sys.argv[3]
		tenant_id = sys.argv[4]
		project_id = sys.argv[5]
	else:
		sys.exit(2)
	cli = Fogbow(username, password, tenant_id, project_id)
 
	if param == "images":
		for elem in cli.get_images(param):
			print(elem['name'] + ";" + elem['id'])
	elif param == "token":
		print(cli.get_token())
	else:
		sys.exit(2)
