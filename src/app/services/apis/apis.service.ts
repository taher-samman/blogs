import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApisService {
  private url = 'http://blogs.backend/';
  categories: (any)[] = [];
  constructor(private http: HttpClient) { }

  login(data: any) {
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/login', formData);
  }
  register(data: any) {
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('email', data['email']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/register', formData);
  }
  getCategories() {
    this.http.get(this.url + 'site/getcategories',
      {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('_blogsToken')
        }
      }
    ).toPromise().then(res => {
      var response: any = { ...res };
      this.categories = response['data'];
    })
  }
  addBlog(data: any) {
    const formData = new FormData();
    formData.append('name', data['name']);
    formData.append('description', data['description']);
    formData.append('category', data['category']);
    return this.http.post(this.url + 'blogs/add', formData,
      {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('_blogsToken')
        }
      });
  }
}

