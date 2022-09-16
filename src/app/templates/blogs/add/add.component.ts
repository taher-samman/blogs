import { Component, OnInit, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ApisService } from 'src/app/services/apis/apis.service';
import { MatSnackBar } from '@angular/material/snack-bar';
@Component({
  selector: 'add-blog',
  templateUrl: './add.component.html',
  styleUrls: ['./add.component.less']
})
export class AddComponent implements OnInit {
  @Input('categories') categories: (any)[] = [];
  form = new FormGroup({
    name: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    category: new FormControl('', Validators.required)
  });
  progressBar = false;
  constructor(private apis: ApisService) { }
  get name() {
    return this.form.get('name');
  }
  get description() {
    return this.form.get('description');
  }
  get category() {
    return this.form.get('category');
  }
  ngOnInit(): void {
  }
  addBlog() {
    this.progressBar = true;
    this.apis.addBlog(this.form.value)
      .toPromise()
      .then(res => console.log('res', res))
      .finally(() => {
        this.progressBar = false;
      });
  }
}
