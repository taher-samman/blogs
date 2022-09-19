import { Component, OnInit, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ApisService } from 'src/app/services/apis/apis.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Event, Router } from '@angular/router';
@Component({
  selector: 'add-blog',
  templateUrl: './add.component.html',
  styleUrls: ['./add.component.less']
})
export class AddComponent implements OnInit {
  categories: (any)[] = [];
  image64:any;
  form = new FormGroup({
    name: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    category: new FormControl('', Validators.required),
    image: new FormControl('',Validators.required)
  });
  progressBar = false;
  constructor(private apis: ApisService, private _snackBar: MatSnackBar) {
    this.categories = this.apis.categories;
  }
  get name() {
    return this.form.get('name');
  }
  get description() {
    return this.form.get('description');
  }
  get category() {
    return this.form.get('category');
  }
  get image() {
    return this.form.get('image');
  }
  ngOnInit(): void {
  }
  handleUpload(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      this.image64 = reader.result;
      this.form.value.image = this.image64;
    };
  }  
  addBlog() {
    this.form.value.image = this.image64;
    this.progressBar = true;
    if(this.form.valid){
      this.apis.addBlog(this.form.value)
      .toPromise()
      .then(res => {
        var data: any = { ...res };
        if (data['status']) {
          this._snackBar.open(`Blog added SUCCESSFLY with id #  ${data['id']}`, 'Success', { duration: 2000, });
          this.apis.getBlogs(true);
        }
      })
      .catch(error => {
        console.log('error', error);
        this._snackBar.open(`can't add blog error: ${error.error.name}`, 'Error', { duration: 5000, });
      })
      .finally(() => {
        this.progressBar = false;
      });
    }else{
      this.progressBar = false;
    }
  }
}
