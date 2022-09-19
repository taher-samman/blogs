import { LoaderService } from './../loader/loader.service';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ApisService {
  private url = 'http://blogs.backend/';
  categories: (any)[] = [];
  blogs: (any)[] = [];
  publicBlogs:(any)[] = [];
  constructor(private http: HttpClient, private router: Router, private loader:LoaderService) { }

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
      this.getHeaders()
    ).toPromise().then(res => {
      var response: any = { ...res };
      if (response['status'])
        this.categories = response['data'];
    })
  }
  getBlogs(gotoblogs: Boolean = false) {
    this.http.get(this.url + 'site/getblogs',
      this.getHeaders()
    ).toPromise().then(res => {
      var response: any = { ...res };
      if (response['status']){
        this.blogs = response['data'];
      }
      if (gotoblogs) {
        this.router.navigate(['blogs']);
      }
    })
  }
  getPublicBlogs() {
    this.loader.show = true;
    this.http.get(this.url + 'site/getallblogs',
      this.getHeaders()
    ).toPromise().then(res => {
      var response: any = { ...res };
      if (response['status']){
        this.publicBlogs = response['data'];
      }
      setTimeout(() => {
        this.loader.show = true;
      }, 3000);
    })
  }
  getBlog(id: number) {
    return this.http.get(this.url + 'blogs/getblog/' + id, this.getHeaders())
  }
  getToken() {
    return localStorage.getItem('_blogsToken')?.replace('"', '').replace('"', '')
  }
  addBlog(data: any) {
    console.log('Data in Apis Request',data)
    const formData = new FormData();
    formData.append('name', data['name']);
    formData.append('description', data['description']);
    formData.append('category', data['category']);
    formData.append('image', data['image']);
    return this.http.post(this.url + 'blogs/add',
      formData,
      this.getHeaders());
  }
  getHeaders() {
    return {
      headers: {
        'Authorization': `Bearer ${this.getToken()}`
      }
    };
  }
  uploadImage(image: File) {
    const formData = new FormData();
    formData.append('value', image.name);
    formData.append('blog_id', '1');
    console.log('image', image)
    this.http.post(this.url + 'blogs/upload', formData, this.getHeaders())
      .toPromise().then(res => console.log('res', res));
  }
}

