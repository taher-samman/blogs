import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApisService {
  private url = 'http://blogs.backend/';
  config = {
    headers: {
      'Access-Control-Allow-Origin': '*',
      // 'Content-Type': 'application/json'
      // 'Authorization' : 'Bearer naPUjdLVpB8nKbMFkff-7O9S133hDwbY'
    }
  }
  constructor(private http: HttpClient) { }
  // Login Function
  login(data: any) {
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/login', formData, this.config);
  }
  register(data: any) {
    console.log('data',data)
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('email', data['email']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/register', formData, this.config);
  }
}