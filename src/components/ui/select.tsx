import { cn } from "@/lib/utils";

interface SelectProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const Select = React.forwardRef<HTMLDivElement, SelectProps>({
  className: "relative w-full rounded-md",
  ...props,
}) => {
  return (
    <div className={cn("relative w-full rounded-md", props.className)} {...props} />
  );
});

Select.displayName = "Select";

interface SelectTriggerProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const SelectTrigger = React.forwardRef<HTMLDivElement, SelectTriggerProps>({
  className: "flex rounded-md bg-background p-1 focus-within:outline-none focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2",
  ...props,
}) => {
  return (
    <div className={cn("flex rounded-md bg-background p-1 focus-within:outline-none focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2", props.className)} {...props} />
  );
});

SelectTrigger.displayName = "SelectTrigger";

interface SelectValueProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const SelectValue = React.forwardRef<HTMLDivElement, SelectValueProps>({
  className: "flex items-center rounded-md bg-secondary px-2.5 py-0.5 text-sm select-none",
  ...props,
}) => {
  return (
    <div className={cn("flex items-center rounded-md bg-secondary px-2.5 py-0.5 text-sm select-none", props.className)} {...props} />
  );
});

SelectValue.displayName = "SelectValue";

interface SelectItemProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const SelectItem = React.forwardRef<HTMLDivElement, SelectItemProps>({
  className: "flex items-center rounded-md px-2 py-1.5 text-sm select-none cursor-default hover:bg-accent hover:text-accent-foreground",
  ...props,
}) => {
  return (
    <div className={cn("flex items-center rounded-md px-2 py-1.5 text-sm select-none cursor-default hover:bg-accent hover:text-accent-foreground", props.className)} {...props} />
  );
});

SelectItem.displayName = "SelectItem";

interface SelectGroupProps extends React.HTMLAttributes<HTMLOptGroupElement> {
  className?: string;
}

const SelectGroup = React.forwardRef<HTMLOptGroupElement, SelectGroupProps>({
  className: "text-sm",
  ...props,
}) => {
  return (
    <optgroup className={cn("text-sm", props.className)} {...props} />
  );
});

SelectGroup.displayName = "SelectGroup";

export { Select, SelectTrigger, SelectValue, SelectItem, SelectGroup };
